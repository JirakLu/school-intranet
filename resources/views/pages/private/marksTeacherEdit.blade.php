@extends("layout.layout_private")

@section("content")
    <div x-data="{
            markDetailModal: false,
            markAddModal: false,
            markAddToAllModal: false,
            addCategoryModal: false,
            removeCategoryModal: false,
            markAddData: {},
            markDetailData: {}
        }"
         class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="text-3xl lg:text-4xl font-semibold text-gray-900">Známky</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <!-- Replace with your content -->
            @include("components.classSelector")
            @if (isset($selected) && isset($marks))
                <div class="py-4">
                    <div class="px-4 py-5 bg-white shadow rounded-lg sm:p-6 flex flex-row justify-between items-center">
                        <h1 class="text-2xl leading-7">Editace:</h1>
                        <div class="flex flex-row gap-4">
                            <button type="button" @click="markAddToAllModal = true"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Přidat známku všem
                                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            <button type="button" @click="addCategoryModal = true"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Přidat kategorii
                                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </button>
                            <button type="button" @click="removeCategoryModal = true"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Správa kategorií
                                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="py-4">
                    <div class="flex flex-col gap-2 px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                        <div class="flex justify-end">
                            <form class="hidden opacity-0" id="export" method="POST" action="{{$createLink("api/marks/export")}}">
                                <input name="courseID" type="text" value="{{$selected["courseID"]}}">
                                <input name="userID" type="text" value="{{\App\Session::get("user_ID")}}">
                                <input name="backURL" type="text" id="backURL" x-bind:value="window.location.href">
                            </form>
                            <button type="submit" form="export" class="flex items-center justify-center rounded-lg bg-indigo-100 hover:bg-indigo-300 cursor-pointer p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </button>
                        </div>
                        <div class="shadow-md rounded-lg overflow-hidden w-full flex flex-col gap-2 md:gap-0 divide-gray-500 md:divide-y-[1px]">
                            @foreach($marks as $markInfo)
                                @include("components.gradesRowTeacher", ["markInfo" => $markInfo, "addMark" => true])
                            @endforeach
                        </div>
                    </div>
                </div>
        @endif
        <!-- /End replace -->
        </div>

        @include("components.markEditModal")
        @include("components.markAddModal")
        @include("components.markAddToAllModal", ["courseID" => $marks[array_key_first($marks)]["courseID"]])
        @include("components.addCategoryModal")
        @include("components.removeCategoryModal")
    </div>
@endsection