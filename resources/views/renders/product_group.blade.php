<table class="table table-striped">
	<thead>
		<th>{{ __('product.name') }}</th>
		<th>{{ __('product.sku') }}</th>
		<th>{{ __('product.price') }}</th>
		<th>{{ __('common.status') }}</th>
		<th>{{ __('common.actions') }}</th>
	</thead>
	<tbody>
		@foreach ($products as $product)
			<tr @if($currentProductId == $product->id) class="tr-current-product" @endif>
				<td>{{ $product->name }}</td>
				<td>{{ $product->sku }}</td>
				<td>{{ decimalFormat($product->price) }}</td>
				<td>{{ $product->active == 1 ? __('common.status') : __('common.inactive') }}</td>
				<td>
					<a href="{{ url('admin/products/'.$product->id.'/edit' ) }}" class="btn btn-xs btn-default" target="_blank">{{ __('common.edit') }}</a>
					@if (count($products) > 1)
						<a href="javascript:void(0)" data-id="{{ $product->id }}" class="btn btn-xs btn-default btn-remove-from-group">
							<i class="fa fa-times"></i> {{ __('product.remove_from_group') }}
						</a>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
