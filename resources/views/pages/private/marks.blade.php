@extends("layout.layout-private")

@section("content")
    <div x-data="{
            markDetailModal: false,
            markDetailData: {
                mark: 1,
                category: 'Test',
                weight: 2,
                desc: '1+1+1+1+1+2+2-500 0% MC. BLACK'
            }
        }"
            class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="text-3xl lg:text-4xl font-semibold text-gray-900">Známky</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-6">
            <!-- Replace with your content -->
            <div class="py-4">
                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6 flex-col w-full
                flex flex-col divide-gray-500 divide-y-[1px]">
                    @foreach([0,1,2,3,4,5,6,7,8,9,10,11,12,13] as $subject)
                        @include("components.gradesRow")
                    @endforeach
                </div>
            </div>
            <!-- /End replace -->
        </div>

        <!-- Modals -->
        @include("components.markDetailModal")
    </div>
@endsection