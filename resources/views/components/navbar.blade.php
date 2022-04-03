<div x-data="{showMobileMenu: false}" class="relative bg-white border-b-2 border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center py-6 md:justify-start md:space-x-10">
            <div class="flex justify-start lg:w-0 lg:flex-1">
                <a href="{{$createLink("home")}}">
                    <span class="sr-only">Workflow</span>
                    <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                         alt="">
                </a>
            </div>
            <div class="-mr-2 -my-2 md:hidden">
                <button @click="showMobileMenu = true" type="button"
                        class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        aria-expanded="false">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            <nav class="hidden md:flex space-x-10">
                <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                <a href="{{$createLink("teachers")}}"
                   class="text-base font-medium hover:text-gray-900 {{$getActiveUrl() === "/teachers" ? "text-gray-900" : "text-gray-500"}}">
                    Učitelé </a>
                <a href="{{$createLink("schedule")}}"
                   class="text-base font-medium hover:text-gray-900 {{$getActiveUrl() === "/schedule" ? "text-gray-900" : "text-gray-500"}}">
                    Rozvrh </a>
                <a href="{{$createLink("school")}}"
                   class="text-base font-medium hover:text-gray-900 {{$getActiveUrl() === "/school" ? "text-gray-900" : "text-gray-500"}}">
                    Škola </a>
                <a href="{{$createLink("news")}}"
                   class="text-base font-medium hover:text-gray-900 {{$getActiveUrl() === "/news" ? "text-gray-900" : "text-gray-500"}}">
                    Novinky </a>
            </nav>
            <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                @if(\App\Session\Session::getIsLoggedIn())
                    <a href="{{$createLink("dashboard")}}"
                       class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Intranet
                    </a>
                @else
                    <a href="{{$createLink("login")}}"
                       class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Přihlásit se
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!--
      Mobile menu.
    -->
    <div
            x-transition:enter="duration-200 ease-out"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="duration-100 ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            x-show="showMobileMenu"
            class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
            <div class="pt-5 pb-6 px-5">
                <div class="flex items-center justify-between">
                    <div>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                             alt="Workflow">
                    </div>
                    <div class="-mr-2">
                        <button @click="showMobileMenu = false" type="button"
                                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-6">
                    <nav class="grid gap-y-8">
                        <a href="{{$createLink("teachers")}}"
                           class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6 text-indigo-600"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                            </svg>
                            <span class="ml-3 text-base font-medium text-gray-900"> Učitelé </span>
                        </a>

                        <a href="{{$createLink("schedule")}}"
                           class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                            <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span class="ml-3 text-base font-medium text-gray-900"> Rozvrh </span>
                        </a>

                        <a href="{{$createLink("school")}}"
                           class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6 text-indigo-600"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                            </svg>
                            <span class="ml-3 text-base font-medium text-gray-900"> Škola </span>
                        </a>

                        <a href="{{$createLink("prestige")}}"
                           class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6 text-indigo-600"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            <span class="ml-3 text-base font-medium text-gray-900"> Novinky </span>
                        </a>
                    </nav>
                </div>
            </div>
            <div class="py-6 px-5 space-y-6">
                @if(\App\Session\Session::getIsLoggedIn())
                    <div>
                        <a href="{{$createLink("dashboard")}}"
                           class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Intranet
                        </a>
                    </div>
                @else
                    <div>
                        <a href="{{$createLink("login")}}"
                           class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Přihlásit se
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
