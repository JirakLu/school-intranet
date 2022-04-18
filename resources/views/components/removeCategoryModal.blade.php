<!-- This example requires Tailwind CSS v2.0+ -->
<div x-show="removeCategoryModal" class="fixed z-10 inset-0 overflow-y-auto overscroll-contain"
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
        <div x-show="removeCategoryModal"
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
        <div x-show="removeCategoryModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.outside="removeCategoryModal = false"
             class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left shadow-xl transform transition-all sm:my-8 sm:align-middle min-h-[450px] w-[350px] sm:max-w-md sm:p-6">
            <h3 class="text-2xl font-normal mb-5">
                Správa kategorií
            </h3>

            @if (!empty($categories))
                <div class="flex flex-col gap-4">
                    <p class="block text-sm font-medium text-gray-700">Vaše kategorie:</p>
                    @foreach ($categories as $category)
                        <form method="POST" action="{{$createLink("api/category/removeCategory")}}" class="flex flex-row py-2 px-4 justify-between items-center rounded-xl border border-gray-300">
                            <input type="text" name="categoryID" id="categoryID" value="{{$category->category_ID}}" class="hidden">
                            <input type="text" name="backURL" id="backURL" x-bind:value="window.location.href" class="hidden">
                            <div>{{$category->label}} - Váha: {{$category->weight}}</div>
                            <div class="flex flex-row gap-2">
                                <span style="background: {{$category->color}}" class="h-6 w-6 rounded-full border border-gray-700"></span>
                                <button type="submit" class="bg-red-500 h-6 w-6 rounded-md text-red-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @endforeach
                </div>
            @else
                <div class="h-full w-full flex items-center justify-center">
                    <h1>Zatím si žádné kategorie nepřidal</h1>
                </div>
            @endif

        </div>
    </div>
</div>
