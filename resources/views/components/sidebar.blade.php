<!-- This example requires Tailwind CSS v2.0+ -->
<div class="hidden flex-1 md:flex flex-col min-h-0 h-screen border-r border-gray-200 bg-white px-2 py-2">
    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
        <div class="flex items-center flex-shrink-0 px-4">
            <img class="h-8 w-auto"
                 src="https://tailwindui.com/img/logos/workflow-logo-indigo-600-mark-gray-800-text.svg" alt="Workflow">
        </div>
        <nav class="mt-5 flex-1 px-2 bg-white flex flex-col justify-between" aria-label="Sidebar">
            <!-- Current: "bg-gray-100 text-gray-900 hover:text-gray-900 hover:bg-gray-100", Default: "text-gray-600 hover:text-gray-900 hover:bg-gray-50" -->
            <div class="space-y-4">
                <a href="{{$createLink("dashboard")}}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-56
                     {{$getActiveUrl() === "/dashboard" ? "bg-gray-100 text-gray-900 hover:text-gray-900 hover:bg-gray-100" : "text-gray-600 hover:text-gray-900 hover:bg-gray-50"}}">
                    <svg class="{{$getActiveUrl() === "/dashboard" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-3 flex-shrink-0 h-6 w-6"
                         xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="flex-1"> Dashboard </span>
                </a>
                <a href="{{$createLink("marks")}}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-56
                    {{$getActiveUrl() === "/marks" ? "bg-gray-100 text-gray-900 hover:text-gray-900 hover:bg-gray-100" : "text-gray-600 hover:text-gray-900 hover:bg-gray-50"}}">
                    <svg class="{{$getActiveUrl() === "/marks" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-3 flex-shrink-0 h-6 w-6"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <span class="flex-1"> Známky </span>
                </a>
                <a href="{{$createLink("absence")}}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-56
                    {{$getActiveUrl() === "/absence" ? "bg-gray-100 text-gray-900 hover:text-gray-900 hover:bg-gray-100" : "text-gray-600 hover:text-gray-900 hover:bg-gray-50"}}">
                    <svg class="{{$getActiveUrl() === "/absence" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-3 flex-shrink-0 h-6 w-6"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="flex-1"> Absence </span>
                </a>
            </div>

            <div>
                <a href="{{$createLink("home")}}"
                   class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md w-56">
                    <!--
                          Heroicon name: outline/home

                          Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"
                        -->
                    <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="flex-1"> Zpět na hlavní stránku </span>
                </a>
            </div>
        </nav>
    </div>
    <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
        <a href="{{$createLink("personal-info")}}" class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
                <div>
                    <img class="inline-block h-9 w-9 rounded-full"
                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                         alt="">
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Adam Pepega</p>
                    <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">Osobní informace</p>
                </div>
            </div>
        </a>
    </div>
</div>
