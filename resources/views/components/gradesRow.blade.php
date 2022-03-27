<div class="flex flex-col md:flex-row w-full divide-gray-500 divide-y-[1px] md:divide-x-[1px] md:divide-y-0">
    <div class="flex place-items-center bg-indigo-100 px-2 py-1">
        <p class="text-sm md:text-base font-medium text-indigo-800">Anglický&nbsp;jazyk&nbsp;(AJ)</p>
    </div>
    <div class="flex flex-row gap-2 flex-wrap w-full px-4 py-2 items-center bg-gray-50">
        @foreach([0,1,2,3,4,5,6,7,8,9] as $mark)
            <div x-data="{
                    markInfo: {
                        mark: {{$mark}},
                        weight: 1,
                        sub_type: 'chráněný režim, procesory x86',
                        teacher: 'Jelínek Radek Ing.',
                        category: 'písemný test, váha 1',
                        desc: '1+1+1+1+1+6+5+4+2 = 78%',
                        date: '10.4.2022'
                    }
                }"
                    @click="markDetailModal = true; markDetailData = markInfo"
                    class="w-6 h-6 rounded-md bg-green-100 hover:bg-green-200 text-green-800 grid place-items-center cursor-pointer">
                <p>{{$mark}}</p>
            </div>
        @endforeach
    </div>
    <div class="flex place-items-center bg-gray-200 px-4 py-1 cursor-pointer hover:bg-gray-100">
        <p class="text-sm md:text-lg font-medium text-gray-800">1</p>
    </div>
</div>