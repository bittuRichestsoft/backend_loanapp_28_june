@extends('layouts.admin')
@section('content')
@can('loan_access')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.loan_duration.create") }}">
                {{ trans('global.add') }} {{ trans('global.loan_duration.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.loan_duration.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.loan_duration.fields.package_name') }}
                        </th>
                        <th>
                            {{ trans('global.loan_duration.fields.number') }}
                        </th>
                        <th>
                            {{ trans('global.loan_duration.fields.calendar_value') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loanDurations as $key => $loanDuration)
                        <tr data-entry-id="{{ $loanDuration->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $loanDuration->package_name ?? '' }}
                            </td>
                            <td>
                                {{ $loanDuration->number ?? '' }}
                            </td>
                            <td>
                                {{ $loanDuration->calendar_value ?? '' }}
                            </td>
                            <td>
                                @can('loan_access')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.loan_duration.show', $loanDuration->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('loan_access')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.loan_duration.edit', $loanDuration->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('loan_access')
                                    <form action="{{ route('admin.loan_duration.destroy', $loanDuration->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan_duration.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('loan_access')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection
@endsection