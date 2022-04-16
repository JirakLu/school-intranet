<!-- This example requires Tailwind CSS v2.0+ -->
<div x-show="markDetailModal" class="fixed z-10 inset-0 overflow-y-auto overscroll-contain"
     aria-labelledby="modal-title"
     role="dialog"
     aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!--
          Background overlay, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div x-show="markDetailModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!--
          Modal panel, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
        <div x-show="markDetailModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.outside="markDetailModal = false"
             class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left shadow-xl transform transition-all sm:my-8 sm:align-middle w-[350px] sm:max-w-md sm:p-6">
            <h3 class="text-2xl font-normal mb-5">
                Upravit známku
            </h3>

            <form id="markEdit" method="POST" action="{{$createLink("api/marks/edit")}}" class="space-y-2">
                <input type="text" name="markID" id="markID" x-bind:value="markDetailData.markID" class="hidden">
                <input type="text" name="backURL" id="backURL" x-bind:value="window.location.href" class="hidden">
                <div>
                    <label for="markCategory" class="block text-sm font-medium text-gray-700">Kategorie: </label>
                    <select id="markCategory" name="markCategory" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach($categories as $category)
                            <option x-bind:selected="markDetailData.markCategoryID === '{{$category->category_ID}}'"
                                    x-bind:class="markDetailData.markCategoryID === '{{$category->category_ID}}' ? 'font-bold' : ''"
                                    class="hover:bg-indigo-600 hover:text-white"
                                    value="{{$category->category_ID}}">{{$category->label}} -
                                Váha: {{$category->weight}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="markType" class="block text-sm font-medium text-gray-700">Známka: </label>
                    <select id="markType" name="markType" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach($markTypes as $type)
                            <option x-bind:selected="markDetailData.markTypeID === '{{$type->mark}}'"
                                    x-bind:class="markDetailData.markTypeID === '{{$type->mark}}' ? 'font-bold' : ''"
                                    class="hover:bg-indigo-600 hover:text-white"
                                    value="{{$type->mark_type_ID}}">{{$type->mark}} - {{$type->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="latka" class="block text-sm font-medium text-gray-700">Látka: </label>
                    <div class="mt-1">
                        <textarea rows="1" name="latka" id="latka" x-text="markDetailData.latka" required
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Poznámka: </label>
                    <div class="mt-1">
                        <textarea rows="4" name="description" id="description" x-text="markDetailData.markDesc" required
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Datum: </label>
                    <input type="date" name="date" id="date" x-bind:value="markDetailData.date" required x-bind:max="new Date().toISOString().split('T')[0]"
                           class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">

                </div>

            </form>

            <div class="flex flex-row py-2 justify-between items-center gap-2 mt-2">
                <button type="submit" form="markEdit"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Upravit
                </button>

                <button type="submit" form="markDel"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Odstranit
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>

            <form id="markDel" method="POST" action="{{$createLink("api/marks/del")}}">
                <input type="text" name="markID" id="markID" x-bind:value="markDetailData.markID" class="hidden">
                <input type="text" name="backURL" id="backURL" x-bind:value="window.location.href" class="hidden">
            </form>
        </div>
    </div>
</div>
