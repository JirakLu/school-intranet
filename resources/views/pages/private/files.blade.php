@extends("layout.layout_private")

@section("content")
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="text-3xl lg:text-4xl font-semibold text-gray-900">Soubory</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <!-- Replace with your content -->
            <div class="py-4">
                <div class="flex flex-col gap-5 px-4 py-5 bg-white overflow-hidden sm:p-6">
                    <div class="flex gap-4 justify-end bg-white border border-gray-200 rounded-lg py-3 px-5 shadow-md">
                        <div class="flex items-center justify-center p-1 border-[3px] border-indigo-500 rounded-lg cursor-pointer group hover:border-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-indigo-500 font-bold group-hover:text-indigo-700" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </div>

                        <div class="flex items-center justify-center p-1 border-[3px] border-indigo-500 rounded-lg cursor-pointer group hover:border-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-indigo-500 font-bold group-hover:text-indigo-700" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>

                        <div class="flex items-center justify-center p-1 border-[3px] border-indigo-500 rounded-lg cursor-pointer group hover:border-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-indigo-500 font-bold group-hover:text-indigo-700" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>

                        <div class="flex items-center justify-center p-1 border-[3px] border-indigo-500 rounded-lg cursor-pointer group hover:border-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-indigo-500 font-bold group-hover:text-indigo-700" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>

                    <nav class="flex" aria-label="Breadcrumb">
                        <ol role="list"
                            class="bg-white border border-gray-200 rounded-md shadow-md px-6 flex space-x-4">
                            <li class="flex h-[46px]">
                                <div class="flex items-center">
                                    <a href="{{$createLink("files")}}" class="text-gray-400 hover:text-gray-500">
                                        <!-- Heroicon name: solid/home -->
                                        <svg class="flex-shrink-0 h-5 w-5 {{$menu["root"][0] ? 'text-indigo-500 font-bold' : ''}}"
                                             xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                        </svg>
                                        <span class="sr-only">Home</span>
                                    </a>
                                </div>
                            </li>

                            @foreach($menu as $key => $item)
                                @if($key != "root")
                                    <li class="flex">
                                        <div class="flex items-center">
                                            <svg class="flex-shrink-0 w-6 h-full text-gray-500" viewBox="0 0 24 44"
                                                 preserveAspectRatio="none" fill="currentColor"
                                                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"/>
                                            </svg>
                                            <a href="{{$createLink("files/" . $item[1])}}"
                                               class="capitalize ml-4 text-sm hover:text-gray-700 {{$item[0] ? 'text-indigo-500 font-bold' : 'font-medium text-gray-500'}}">{{$key}}</a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>

                    <form action="{{$createLink("api/folder")}}" method="POST"
                          class="border border-gray-200 bg-white rounded-lg py-3 px-5 shadow-md">
                        <fieldset>
                            <legend class="sr-only">Složky</legend>
                            <div class="flex gap-8 flex-wrap">

                                @if(empty($folders) && empty($files))
                                    <div class="px-4 py-2">
                                        <span class="text-2xl leading-7 font-semibold">Máš tu nějak prázdno 🤔</span>
                                    </div>
                                @endif

                                @foreach($folders as $folder)
                                    <label @dblclick="window.location = '{{$createLink("files/" . $folder->getFolderID())}}'"
                                           for="folder-{{$folder->getFolderID()}}"
                                           class="relative cursor-pointer flex items-center justify-center flex-col gap-1 p-2 pt-3">
                                        <svg class="h-16 w-16" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 58 58" xml:space="preserve">
                                            <path style="fill:#EFCE4A;" d="M46.324,52.5H1.565c-1.03,0-1.779-0.978-1.51-1.973l10.166-27.871
                                                c0.184-0.682,0.803-1.156,1.51-1.156H56.49c1.03,0,1.51,0.984,1.51,1.973L47.834,51.344C47.65,52.026,47.031,52.5,46.324,52.5z"/>
                                            <path style="fill:#EBBA16;" d="M50.268,12.5H25l-5-7H1.732C0.776,5.5,0,6.275,0,7.232V49.96c0.069,0.002,0.138,0.006,0.205,0.01
                                                l10.015-27.314c0.184-0.683,0.803-1.156,1.51-1.156H52v-7.268C52,13.275,51.224,12.5,50.268,12.5z"/>
                                    </svg>
                                        <span class="text-sm text-gray-700 font-semibold capitalize">{{$folder->getName()}}</span>

                                        <input id="folder-{{$folder->getFolderID()}}" name="folder-{{$folder->getFolderID()}}" value="folder-{{$folder->getFolderID()}}"
                                               type="checkbox"
                                               class="absolute top-0.5 right-0.5 focus:!ring-0 focus:!outline-0 h-4 w-4 text-amber-600 border-gray-300 rounded">
                                    </label>
                                @endforeach

                                @foreach($files as $file)
                                    <label @dblclick="window.location = '{{$createLink("api/file/" . $file->getFileID())}}'"
                                           for="file-{{$file->getFileID()}}"
                                           class="relative cursor-pointer flex items-center justify-center flex-col gap-1 p-2 pt-3">
                                        <svg class="h-16 w-16" viewBox="0 0 48 48"
                                             xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
                                            <polygon fill="#90CAF9" points="40,45 8,45 8,3 30,3 40,13"/>
                                            <polygon fill="#E1F5FE" points="38.5,14 29,14 29,4.5"/>
                                            <g fill="#1976D2">
                                                <rect x="16" y="21" width="17" height="2"/>
                                                <rect x="16" y="25" width="13" height="2"/>
                                                <rect x="16" y="29" width="17" height="2"/>
                                                <rect x="16" y="33" width="13" height="2"/>
                                            </g>
                                        </svg>

                                        <span class="text-sm text-gray-700 font-semibold capitalize">{{$file->getName()}}.<span class="lowercase">{{$file->getFileType()}}</span></span>

                                        <input id="file-{{$file->getFileID()}}" name="file-{{$file->getFileID()}}" value="file-{{$file->getFileID()}}"
                                               type="checkbox"
                                               class="absolute top-0.5 right-0.5 focus:!ring-0 focus:!outline-0 h-4 w-4 text-blue-500 border-gray-300 rounded">
                                    </label>
                                @endforeach

                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- /End replace -->
        </div>
    </div>
@endsection