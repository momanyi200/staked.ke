@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex items-center justify-between transition-opacity duration-300 ease-out opacity-100">
            <p class="text-sm">{{$error}}</p>
            <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.style.opacity = 0; setTimeout(() => this.parentElement.remove(), 300);">&times;</button>
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 flex items-center justify-between transition-opacity duration-300 ease-out opacity-100">
        <p class="text-sm">{{session('success')}}</p>
        <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.style.opacity = 0; setTimeout(() => this.parentElement.remove(), 300);">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex items-center justify-between transition-opacity duration-300 ease-out opacity-100">
        <p class="text-sm">{{session('error')}}</p>
        <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.style.opacity = 0; setTimeout(() => this.parentElement.remove(), 300);">&times;</button>
    </div>
@endif

