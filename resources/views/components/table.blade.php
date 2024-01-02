<form action="" method="get" role="form">
    <div class="row">
        <div class="col col-md-3">
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" id="searchBox"
                    aria-describedby="searchHelp" />
            </div>
        </div>
        @if (isset($locations))
            <div class="col col-md-2">
                <select name="location" id="location">
                    <option value="">--- All ---</option>
                    @foreach ($locations as $location)
                        <option {{request()->place==$location->id?'selected':''}} value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="col col-md-1">
            <a href="{{ $route }}" class="btn btn-danger reset-btn">Reset</a>
        </div>
    </div>
</form>
<input type="hidden" id="current_route" value="{{ $route }}">
<div class="dataTableDiv">
    <table class="table mt-4 striped">
        <thead>
            @foreach ($columns as $column)
                <th class="{{ $column['sort'] ? 'sorting' : '' }}" data-sort="{{ $column['sort'] }}"
                    data-column="{{ $column['column'] }}" scope="col">
                    {{ $column['label'] }}
                </th>
            @endforeach
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
{!! $data->withQueryString()->links('pagination::bootstrap-5') !!}
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* For Firefox */
    input[type=number] {
        -moz-appearance: textfield;
        text-align: center;
    }

    .reset-btn {
        padding: 11px 15px !important;
    }
</style>
@push('scripts')
    <script>
        var table = {
            search: '',
            place: '',
            orderedColumn: "",
            orderBy: 'asc',
        }
        $(document).ready(function() {
            let search = new URLSearchParams(window.location.search).get("search");
            let orderedColumn = new URLSearchParams(window.location.search).get("orderedColumn");
            let orderBy = new URLSearchParams(window.location.search).get("orderBy");

            table.search = search ? search : '';
            $('#searchBox').val(search ? search : '');
            table.orderedColumn = orderedColumn ? orderedColumn : '';
            table.orderBy = orderBy ? orderBy : '';
        });

        $(document).on('click', '.sorting', function() {
            var isSort = $(this).data('sort');
            var column = $(this).data('column');
            if (isSort) {
                let orderBy = new URLSearchParams(window.location.search).get("orderBy");
                if (!orderBy) {
                    table.orderBy = 'asc';
                } else if (orderBy == 'asc') {
                    table.orderBy = 'desc'
                } else {
                    table.orderBy = 'asc';
                }
                table.orderedColumn = column;
                getRecords();
            }
        });

        $('#searchForm').submit(function(e) {
            e.preventDefault();
            table.search = $('#searchBox').val();
            getRecords();
        });
        $('#searchBox').on('change', function(e) {
            e.preventDefault();
            table.search = $(this).val();
            getRecords();
        })
        $('#location').on('change', function(e) {
            e.preventDefault();
            table.place = $(this).val();
            getRecords();
        })

        function getRecords() {
            let route_name = $('#current_route').val();
            let url = route_name + `?${$.param( table )}`;
            window.location.href = url;
        }
    </script>
@endpush
