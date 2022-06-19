@extends('layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div id="data-grid"></div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <div id="data-grid2"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ mix('js/custom-store.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-grid').dxDataGrid({
                dataSource: '/data/customers.json',
                columns: ['CompanyName', 'City', 'State', 'Phone', 'Fax'],
                showBorders: true,
            });

            const customStoreOptions = createCustomStoreOptions('id', {
                load: '{{ route('data-grid-data') }}',
            });

            $('#data-grid2').dxDataGrid({
                dataSource: new DevExpress.data.CustomStore(customStoreOptions),
                showBorders: true,
                remoteOperations: {
                    filtering: true,
                    groupPaging: false,
                    grouping: false,
                    paging: true,
                    sorting: true,
                    summary: false
                },
                paging: {
                    pageSize: 10,
                },
                headerFilter: {
                    visible: true,
                },
            });
        });
    </script>
@endsection
