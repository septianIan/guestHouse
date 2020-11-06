<div class="btn-group align-middle py-0">
   {{-- Edit --}}
   <a href="/reception/{{ request()->segment(3) }}/{{ $model->id }}/edit" class="btn btn-success"><i class="fa fa-edit"></i></a>
   {{-- Delete --}}
   <button class="btn btn-danger" type="submit" data-id="{{ $model->id }}" id="delete">
      <i class="fa fa-trash"></i>
   </button>
   {{-- Detail --}}
   <a href="/reception/{{ request()->segment(3) }}/{{ $model->id }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
</div>
