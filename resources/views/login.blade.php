@extends('template.mobile')
@section('title')
    Login
@endsection
@section('content')
    <div class="h-screen overflow-y-hidden relative flex flex-col">
        <div class="py-8 mt-8 flex flex-col items-center">
            <div class="flex justify-center items-center">
                <img src="{{asset('icons/Logogram.png')}}" alt="">
                <p class="font-bold text-slate-700 text-3xl">&nbsp;Simple E-Banking</p>
            </div>
            <div class="mt-10">
                <p class="text-center font-bold">Login!</p>
                <p class="text-center text-slate-500">Login sekarang!</p>
            </div>
        </div>
        <div class="px-8">
            @if(session("error"))
                <div class="p-4 border border-red-500 bg-red-100 text-red-500 rounded-xl font-bold text-center">{{session("error")}}</div>
             @endif
            <form action="{{route('login.post')}}" method="post" >
                @csrf
                <div class="w-full my-2 flex flex-col relative">
                    <label for="email" class="mb-2 font-bold">Email<span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" class="text-blue-500 outline-0 border border-slate-500 rounded-full focus:border-blue-500 py-4 pl-10" id="email" placeholder="Masukan email Anda disini...">
                    <svg class="absolute bottom-[18px] left-[16px]" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div class="w-full my-2 flex flex-col relative">
                    <label for="password" class="mb-2 font-bold">Password<span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" class="text-blue-500 outline-0 border border-slate-500 rounded-full focus:border-blue-500 py-4 pl-10 pr-8" id="email" placeholder="Masukan password Anda disini...">
                    <svg class="absolute bottom-[18px] left-[16px]" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                    <svg onclick="showPassword(this);" class="cursor-pointer absolute right-3 bottom-4" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                    <svg onclick="showPassword(this);" class="cursor-pointer absolute right-3 bottom-4 hidden" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>
                <div class="my-4 flex justify-between items-center">
                    <div class="pl-2">
                        <input type="checkbox" name="remindsme" id="remindsme"> <label for="remindsme" class="text-md">&nbsp;Ingat Saya</label>
                    </div>
                    {{-- <div class="">
                        <a href="#" class="text-blue-500 font-bold">Lupa password?</a>
                    </div> --}}
                </div>
                <div class="mt-4">
                    <button class="w-full bg-blue-500 text-white font-bold py-4 rounded-full">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    // @if(session("success"))
    //     $.Toast("Pesan Notifikasi","{{session('success')}}", "success");
    // @endif
    // @if(session("errors"))
    //     $.Toast("Pesan Notifikasi","{{session('errors')}}", "error");
    // @endif

    const showPassword = (self) => {
        let parent = $(self).parent();
        let showIcon = parent.children().eq(4);
        let hideIcon = parent.children().eq(3);
        let password = parent.find("input");
        if(password.attr("type") == "password") {
            password.attr("type","text");
            hideIcon.addClass("hidden");
            showIcon.removeClass("hidden");
        } else {
            password.attr("type","password");
            showIcon.addClass("hidden");
            hideIcon.removeClass("hidden");
        }
    }
</script>
@endsection