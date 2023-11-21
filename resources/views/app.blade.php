@extends('template.mobile')
@section('title')
    Login
@endsection
@section('content')
    <div id="navbar" class="px-4 overflow-y-scroll  pt-10 pb-4 flex justify-between">
        <div class="min-h-[100vh] w-full">
            <div class="flex items-center my-4">
                <img src="https://ui-avatars.com/api/?name={{$user->name}}" class="w-10 rounded-full border-2 border-gray-500" alt="">
                <p class="mx-2 text-sm">Hi, <span class="font-bold text-green-800">{{$user->name}}</span></p>
            </div>
            <div class="p-4 text-white bg-green-800 shadow w-full rounded-lg">
                <div class="flex justify-between">
                    <div class="flex flex-col justify-center">
                        <p class="text-lg">Total Saldo</p>
                        <p class="text-2xl">Rp. {{$user->balance}}</p>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <p class="text-lg">Total Transaksi</p>
                        <p class="text-2xl">{{count($user->mutations)}}</p>
                    </div>
                </div>
            </div>
            <div class="my-4">
                {{dd($user)}}
                <p class="text-2xl">Daftar Mutasi</p>
                <div class="flex flex-col">
                    @foreach ($user->mutations as $mutasi)
                        <div class="my-2 p-4 border-2 bg-gray-100 rounded-lg">
                            <div class="p-2 bg-green-500 rounded-full w-[40px] flex items-center text-white">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">{{$mutasi->getUser()->name}} {{$mutasi->id}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
