<div class="flex justify-center">
    <div class="w-6/12">
        <h1 class="my-10 text-3x1">comments</h1>
        @error('newComment')
            <span class="text-red-500 text-xs">{{$message}}</span>
        @enderror

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message')}}
            </div>
        @endif
        <select>
            <input type="file" id="image" wire:change="$emit('fileChoosen')">
            @if ($image)
                <img src={{$image}}  width="200"/>
            @endif
        </select>

        <form class="my-4 flex" wire:submit.prevent='addComment'>
            <input type="text" class="w-full rounded border shadow p-2 mr-2 my-2" placeholder="what's in your mind." wire:model.debounce.500ms = 'newComment'>
            <div class="py-2">
                <button type="submit" class="p-2 bg-blue-500 w-20 round shadow text-white">Add</button>
            </div>
        </div>
        @foreach ($comments as $comment)
            <div class="rounded border shadow p-3 my-2">
                <div class="flex justify-start my-2">
                    <p class="font-bold text-lg">{{ $comment->creator->name}}</p>
                    <button wire:click="remove({{$comment->id}})">delete</button>
                    <p class="mx-3 py-1 text-xs text-gray-500 font-semibold">{{ $comment->created_at->diffForHumans()}}</p>
                </div>
                <p class="text-gray-800">{{ $comment->body}}</p>
            </div>
        @endforeach
        
        <div>{{ $comments->links('pagination-links')}}</div>

    </div>
</div>

<script>
    window.livewire.on('fileChoosen', () =>{
        let inputField = document.getElementById('image')

        let file = inputField.files[0]

        let reader = new FileReader();

        reader.onloadend = () =>{
            window.livewire.emit('fileUpload', reader.result)
        }
        
        reader.readAsDataURL(file);
    })
</script>
