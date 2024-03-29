<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="{{$generateBase()}}">
    <title>I5NET</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix("css/app.css") }}" type="text/css">

</head>
<body id="body">
<div class="relative min-h-screen min-w-screen bg-gray-100">
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div x-data="{showMenu: false}">
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div x-show="showMenu" class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true">
            <!--
              Off-canvas menu overlay, show/hide based on off-canvas menu state.

              Entering: "transition-opacity ease-linear duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "transition-opacity ease-linear duration-300"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-show="showMenu" class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>

            <!--
              Off-canvas menu, show/hide based on off-canvas menu state.

              Entering: "transition ease-in-out duration-300 transform"
                From: "-translate-x-full"
                To: "translate-x-0"
              Leaving: "transition ease-in-out duration-300 transform"
                From: "translate-x-0"
                To: "-translate-x-full"
            -->
            <div x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 x-show="showMenu" class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                <!--
                  Close button, show/hide based on off-canvas menu state.

                  Entering: "ease-in-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                  Leaving: "ease-in-out duration-300"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div x-transition:enter="ease-in-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in-out duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="showMenu = false" type="button"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <img class="h-8 w-auto"
                             src="https://tailwindui.com/img/logos/workflow-logo-indigo-600-mark-gray-800-text.svg"
                             alt="Workflow">
                    </div>
                    <nav class="mt-5 px-2 flex flex-col justify-between h-[calc(100vh-170px)]">
                        <div class="space-y-2">
                            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                            <a href="{{$createLink("dashboard")}}"
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md
                           {{$getActiveUrl() === "/dashboard" ? "bg-gray-100 text-gray-900" : "text-gray-600 hover:bg-gray-50 hover:text-gray-900"}}">
                                <!--
                                      Heroicon name: outline/home

                                      Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"
                                    -->
                                <svg class="{{$getActiveUrl() === "/dashboard" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-4 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Dashboard
                            </a>

                            <a href="{{$createLink("marks")}}"
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md
                           {{$getActiveUrl() === "/marks" ? "bg-gray-100 text-gray-900" : "text-gray-600 hover:bg-gray-50 hover:text-gray-900"}}">
                                <!-- Heroicon name: outline/users -->
                                <svg class="{{$getActiveUrl() === "/marks" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-4 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.5">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                </svg>
                                Známky
                            </a>

                            <a href="{{$createLink("absence")}}"
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md
                           {{$getActiveUrl() === "/absence" ? "bg-gray-100 text-gray-900" : "text-gray-600 hover:bg-gray-50 hover:text-gray-900"}}">
                                <!-- Heroicon name: outline/folder -->
                                <svg class="{{$getActiveUrl() === "/absence" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-4 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Absence
                            </a>

                            <a href="{{$createLink("files")}}"
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md
                           {{$getActiveUrl() === "/files" ? "bg-gray-100 text-gray-900" : "text-gray-600 hover:bg-gray-50 hover:text-gray-900"}}">
                                <!-- Heroicon name: outline/folder -->
                                <svg class="{{$getActiveUrl() === "/files" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-4 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                Soubory
                            </a>

                        </div>

                        <div class="space-y-2">
                            <a href="{{$createLink("home")}}"
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <!-- Heroicon name: outline/calendar -->
                                <svg class="text-gray-400 group-hover:text-gray-500 mr-4 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Zpět na hlavní stránku
                            </a>

                            <a href="{{$createLink("login/logout")}}"
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <!-- Heroicon name: outline/calendar -->
                                <svg class="text-gray-400 group-hover:text-gray-500 mr-4 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Odhlásit se
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <a href="{{$createLink("personal-info")}}" class="flex-shrink-0 group block">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-base font-medium text-gray-700 group-hover:text-gray-900">{{$firstName . " " . $lastName}}</p>
                                <p class="text-sm font-medium text-gray-500 group-hover:text-gray-700">Osobní
                                    informace</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="flex-shrink-0 w-14">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <a href="{{$createLink("home")}}" class="flex items-center flex-shrink-0 px-4">
                        <img class="h-8 w-auto"
                             src="https://tailwindui.com/img/logos/workflow-logo-indigo-600-mark-gray-800-text.svg"
                             alt="Workflow">
                    </a>
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
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.5">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                </svg>
                                <span class="flex-1"> Známky </span>
                            </a>
                            <a href="{{$createLink("absence")}}"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-56
                    {{$getActiveUrl() === "/absence" ? "bg-gray-100 text-gray-900 hover:text-gray-900 hover:bg-gray-100" : "text-gray-600 hover:text-gray-900 hover:bg-gray-50"}}">
                                <svg class="{{$getActiveUrl() === "/absence" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-3 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="flex-1"> Absence </span>
                            </a>
                            <a href="{{$createLink("files")}}"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-56
                    {{$getActiveUrl() === "/files" ? "bg-gray-100 text-gray-900 hover:text-gray-900 hover:bg-gray-100" : "text-gray-600 hover:text-gray-900 hover:bg-gray-50"}}">
                                <svg class="{{$getActiveUrl() === "/files" ? "text-gray-500" : "text-gray-400 group-hover:text-gray-500"}} mr-3 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                <span class="flex-1"> Soubory </span>
                            </a>
                        </div>

                        <div class="space-y-4">
                            <a href="{{$createLink("home")}}"
                               class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md w-56">
                                <!--
                                      Heroicon name: outline/home
                                    -->
                                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span class="flex-1"> Zpět na hlavní stránku </span>
                            </a>

                            <a href="{{$createLink("login/logout")}}"
                               class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md w-56">
                                <!--
                                      Heroicon name: outline/home
                                -->
                                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="flex-1"> Odhlásit se </span>
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
                                <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{$firstName. " " . $lastName}}</p>
                                <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">Osobní
                                    informace</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="sticky top-0 z-10 md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3 bg-gray-100">
                <button @click="showMenu = true" type="button"
                        class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open sidebar</span>
                    <!-- Heroicon name: outline/menu -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            <main class="flex-1">
                @yield("content")
            </main>
        </div>
    </div>

</div>
<script src="{{ mix("js/app.js") }}" defer></script>
</body>
</html>