@extends("layout.layout-private")

@section("content")
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="text-3xl lg:text-4xl font-semibold text-gray-900">Dashboard</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <!-- Replace with your content -->
            <div class="py-4 mt-4 md:mt-16 flex flex-col gap-16">
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Studijí úspěchy 🥳</h3>
                    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Odstudovaných hodin</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">285 hodin</dd>
                        </div>

                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Absence</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">24 hodin</dd>
                        </div>

                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Počet získaných známek</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">185</dd>
                        </div>
                    </dl>
                </div>

                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="w-full space-y-2">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Nedávné známky</h3>
                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6 flex flex-col gap-4 justify-between h-full">
                            <div class="flex flex-col justify-around h-full">
                                <div class="space-y-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Dnes</h3>
                                    <div class="flex flex-row gap-3 flex-wrap">
                                        @foreach([0,1,2] as $mark)
                                            @include("components.mark", ["subject" => "Ma", "mark" => 5])
                                        @endforeach
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Minulý týden</h3>
                                    <div class="flex flex-row gap-3 flex-wrap">
                                        @foreach([0,1,2,3,4,5,6,7,8,9] as $mark)
                                            @include("components.mark", ["subject" => "Čj", "mark" => 5])
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="grid place-items-center mt-4">
                                <a href="{{$createLink("marks")}}"
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-base
                                    font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2
                                    focus:ring-offset-2 focus:ring-indigo-500 self-center">
                                    Zobrazit více
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full space-y-2">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Absence</h3>
                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6 flex flex-col gap-4 justify-between h-full">
                            <div class="space-y-4">
                                @foreach([0,1] as $test)
                                    @include("components.absence", ["excused" => false])
                                @endforeach
                                @foreach([0,1,2] as $test)
                                    @include("components.absence", ["excused" => true])
                                @endforeach
                            </div>
                            <div class="grid sm:grid-cols-3 place-items-center mt-4">
                                <div class="hidden sm:flex flex-col gap-2 justify-self-start">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                      <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-800" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                      </svg>
                                      Neomluvené
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                      <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-800" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                      </svg>
                                      Omluvené
                                    </span>
                                </div>
                                <a href="{{$createLink("absence")}}"
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-base
                                    font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2
                                    focus:ring-offset-2 focus:ring-indigo-500 self-center">
                                    Zobrazit více
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /End replace -->
    </div>

@endsection