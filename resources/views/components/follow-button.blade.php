<div>
    <div class="flex">
        <div class="flex-shrink-0 mr-3">
            <a href="{{ route('profiles.show', $user) }}">
                <img src="{{ $user->avatar }}" alt="" class="rounded-full mr-2 absolute bottom-0 transform -translate-x-1/2 translate-y-1/2" style="left: 50%" width="50">
            </a>
        </div>

        <div>
            <a href="{{ route('profiles.show', $user) }}">
                <h5 class="font-bold mb-4">{{ $user->name }}</h5>
            </a>

            <form method="POST" action="/profiles/{{ $user->username }}/follow">
                @csrf

                <button type="submit" class="bg-blue-500 rounded-full shadow py-2 px-4 text-white text-xs">
                    {{-- {{ auth()->user()->profile->isFollowing($user->profile) ? 'Unfollow Me' : 'Follow Me' }} --}}
                </button>
            </form>
        </div>
    </div>