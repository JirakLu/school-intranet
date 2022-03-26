<div class="flex flex-col md:flex-row w-full divide-gray-500 divide-x-[1px]">
    <div class="flex place-items-center bg-indigo-100 px-2 py-1">
        <p class="text-sm md:text-base font-medium text-indigo-800">Anglický&nbsp;jazyk&nbsp;(AJ)</p>
    </div>
    <div class="flex flex-row gap-2 flex-wrap w-full px-4 py-2 items-center bg-gray-50">
        @foreach([0,1,2,3,4,5,6,7,8,9] as $mark)
            <div @click="markDetailModal = true"
                    class="w-6 h-6 rounded-md bg-green-100 hover:bg-green-200 text-green-800 grid place-items-center cursor-pointer">
                <p>{{$mark}}</p>
            </div>
        @endforeach
    </div>
    <div class="flex place-items-center bg-gray-200 px-4 py-1 cursor-pointer hover:bg-gray-100">
        <p class="text-sm md:text-lg font-medium text-gray-800">1</p>
    </div>
</div>