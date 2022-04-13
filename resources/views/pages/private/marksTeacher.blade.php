@extends("layout.layout_private")

@section("content")
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="text-3xl lg:text-4xl font-semibold text-gray-900">Známky</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-6">
            <!-- Replace with your content -->
            <div class="py-4">
                <div class="px-4 py-5 bg-white shadow rounded-lg  sm:p-6 grid grid-cols-3 gap-10">
                    @if (!empty($form["classTeacher"][0]))
                        <div x-data="{open: false}">
                            <label id="listbox-label" class="block text-sm font-medium text-gray-700">Třídní</label>
                            <div class="mt-1 relative">
                                <button type="button" @click="open = true"
                                        class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        aria-haspopup="listbox" aria-expanded="true"
                                        aria-labelledby="listbox-label">
                                    <span class="block truncate"> Prosím vyberte si třídu </span>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor"
                                             aria-hidden="true">
                                          <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd"/>
                                        </svg>
                                      </span>
                                </button>

                                <!--
                                  Select popover, show/hide based on select state.

                                  Entering: ""
                                    From: ""
                                    To: ""
                                  Leaving: "transition ease-in duration-100"
                                    From: "opacity-100"
                                    To: "opacity-0"
                                -->
                                <ul x-show="open"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    @click.outside="open = false"
                                    class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                    tabindex="-1" role="listbox" aria-labelledby="listbox-label"
                                    aria-activedescendant="listbox-option-3">

                                    @foreach($form["classTeacher"] as $className)
                                        <li @click="window.location.href = 'http://localhost/school-intranet/marks/{{$className["id"]}}'"
                                            class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-700 hover:text-white"
                                            id="listbox-option-0" role="option">
                                            <span class="font-normal block truncate"> {{$className["title"]}} </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (!empty($form["courseTeacher"]))
                        <div x-data="{open: false}">
                            <label id="listbox-label" class="block text-sm font-medium text-gray-700">Vyučující</label>
                            <div class="mt-1 relative">
                                <button type="button" @click="open = true"
                                        class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        aria-haspopup="listbox" aria-expanded="true"
                                        aria-labelledby="listbox-label">
                                    <span class="block truncate"> Prosím vyberte si vaší skupinu </span>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor"
                                             aria-hidden="true">
                                          <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd"/>
                                        </svg>
                                      </span>
                                </button>

                                <!--
                                  Select popover, show/hide based on select state.

                                  Entering: ""
                                    From: ""
                                    To: ""
                                  Leaving: "transition ease-in duration-100"
                                    From: "opacity-100"
                                    To: "opacity-0"
                                -->
                                <ul x-show="open"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    @click.outside="open = false"
                                    class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                    tabindex="-1" role="listbox" aria-labelledby="listbox-label"
                                    aria-activedescendant="listbox-option-3">

                                    @foreach($form["courseTeacher"] as $courseName)
                                        <li @click="window.location.href = 'http://localhost/school-intranet/marks/{{ $courseName["id"] }}'"
                                            class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-700 hover:text-white"
                                            id="listbox-option-0" role="option">
                                            <span class="font-normal block truncate"> {{ $courseName["title"] }} </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                        @if (!empty($form["garant"]))
                            <div x-data="{open: false}">
                                <label id="listbox-label" class="block text-sm font-medium text-gray-700">Garant</label>
                                <div class="mt-1 relative">
                                    <button type="button" @click="open = true"
                                            class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            aria-haspopup="listbox" aria-expanded="true"
                                            aria-labelledby="listbox-label">
                                        <span class="block truncate"> Prosím vyberte si váš předmět </span>
                                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor"
                                             aria-hidden="true">
                                          <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd"/>
                                        </svg>
                                      </span>
                                    </button>

                                    <!--
                                      Select popover, show/hide based on select state.

                                      Entering: ""
                                        From: ""
                                        To: ""
                                      Leaving: "transition ease-in duration-100"
                                        From: "opacity-100"
                                        To: "opacity-0"
                                    -->
                                    <ul x-show="open"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        @click.outside="open = false"
                                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                        tabindex="-1" role="listbox" aria-labelledby="listbox-label"
                                        aria-activedescendant="listbox-option-3">

                                        @foreach($form["garant"] as $subjectName)
                                            <li @click="window.location.href = 'http://localhost/school-intranet/marks/{{ $subjectName["id"] }}'"
                                                class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-700 hover:text-white"
                                                id="listbox-option-0" role="option">
                                                <span class="font-normal block truncate"> {{ $subjectName["title"] }} </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                </div>
            </div>
            <!-- /End replace -->
        </div>

    </div>
@endsection