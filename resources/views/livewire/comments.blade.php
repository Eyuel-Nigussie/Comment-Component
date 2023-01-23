<div class="container flex flex-col  space-y-5 mx-auto mt-10 bg-slate-100 drop-shadow-lg p-10 max-w-screen-md">
    <h1 class="self-start p-10 pl-0 text-2xl md:text-5xl font-black">Comments</h1>
    {{-- success message --}}
    @if(session()->has('message'))
        <div class="alert alert-success p-2 bg-green-300 text-black">
            {{ session('message') }}
        </div>
    @endif
    <section>
        @if($image)
        <img src="{{$image}}" alt="" width="100" height="100">
        @endif
        <input type="file" id="image" wire:change="$emit('fileChoosen')">
    </section>
    <form wire:submit.prevent="addComment" class="self-start flex flex-row space-x-5" >
        @error('newComment') <span class="error text-red-500 text-xs">{{ $message }}</span>@enderror
        <input type="text" wire:model.debounce="newComment" size="50" placeholder="What's in your mind." class="px-2 py-2 bg-white border focus:ring-2 shadow-sm"> 
        <button type="submit" class="bg-blue-500 px-7 py-2 border border-blue-700 text-white rounded-md">Add</button>
    </form>

    
    {{-- display the comments --}}
    @foreach($comments as $comment)
    <div class="bg-white p-5 w-95 flex flex-row justify-between ">
        <div>
            <div class="flex flex-row space-x-3 font-semibold">
                <h6>{{ $comment->creator->name }}</h6>
                <span class="text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p>{{ $comment->body }}</p>
        </div>
        <div class="self-start"><i wire:click="remove({{$comment->id}})" class="fa-regular fa-circle-xmark text-red-300 hover:text-red-600 cursor-pointer"></i></div>
    </div>
    @endforeach
    
    <div>{{ $comments->links('pagination') }}</div>
</div>

<script>
    window.livewire.on('fileChoosen', () => {
        let inputField = document.getElementById('image')
        let file = inputField.files[0]
        let reader = new FileReader();
        reader.onloadend = () => {
            window.livewire.emit('fileUpload', reader.result)
        }
        reader.readAsDataURL(file);
    })
</script>