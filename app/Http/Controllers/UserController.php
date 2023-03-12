<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\ReplyResource;
use App\Http\Resources\ThreadResource;
use App\Http\Resources\UserResource;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class UserController extends Controller
{
    private const DISK = 'public';
    private const USER_FILES_DIRECTORY = 'user';

    public function show(int $id): JsonResponse
    {
        $user = User::withCount(['createdForums', 'threads', 'replies', 'roles'])->findOrFail($id);

        return new JsonResponse([
            'user' => new UserResource($user)
        ]);
    }

    public function threads(int $userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        $authUser = Auth::guard('sanctum')->user();
        $threads = [];
        $relations = ['user', 'forum'];

        if ($authUser?->can('view all threads') && $authUser?->can('view all forums')) {
            $threads = $user
                ->threads()
                ->with($relations)
                ->withCount('replies')
                ->get();
        } else {
            $threads = $user
                ->publishedThreads()
                ->whereHas('forum', function(Builder $query) {
                    $query->published();
                })
                ->with($relations)
                ->withCount('replies')
                ->get();
        }

        return new JsonResponse([
            'threads' => ThreadResource::collection($threads)
        ]);
    }

    public function replies(int $userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        $authUser = Auth::guard('sanctum')->user();
        $replies = [];
        $relations = ['thread', 'user'];

        if ($authUser?->can('view all threads') && $authUser?->can('view all forums')) {
            $replies = $user
                ->replies()
                ->with($relations)
                ->get();
        } else {
            $replies = $user
                ->replies()
                ->with($relations)
                ->whereHas('thread', function(Builder $query) {
                    $query
                        ->published()
                        ->whereHas('forum', function(Builder $query) {
                            $query->published();
                        });
                })
                ->get();
        }

        return new JsonResponse([
            'replies' => ReplyResource::collection($replies)
        ]);
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        return new JsonResponse([
            'users' => UserResource::collection($users)
        ]);
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $user->update($request->validated());

        $user->save();

        return new JsonResponse([
            'message' => 'Updated successfully.',
            'user' => new UserResource($user),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $this->authorize('destroy', $user);

        $user->delete();

        return new JsonResponse([
            'message' => 'The user has been successfully deleted.'
        ]);
    }

    public function storeAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => [
                'required', File::image()->types(['image/jpeg', 'image/png'])
            ]
        ]);

        $avatarPath = $request->file('avatar')->store(self::USER_FILES_DIRECTORY, self::DISK);

        return new JsonResponse([
            'avatarPath' => asset('storage/' . $avatarPath),
        ], 201);
    }

    public function destroyAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatarPath' => 'string|required'
        ]);

        Storage::disk(self::DISK)->delete($request->avatarPath);

        return new JsonResponse([
            'message' => 'Avatar has been successfully removed.'
        ]);
    }
}
