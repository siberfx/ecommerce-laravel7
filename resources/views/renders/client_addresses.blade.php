@if (count($addresses) > 0)
	<table class="table table-dashed" >
		<thead>
			<th>{{ __('address.contact_person') }}</th>
			<th>{{ __('address.address') }}</th>
			<th>{{ __('address.mobile_phone') }}</th>
			<th>{{ __('address.comment') }}</th>
			<th>{{ __('common.actions') }}</th>
		</thead>
		<tbody>
			@foreach ($addresses as $address)
				<tr>
					<td class="vertical-align-middle">{{ $address->name }}</td>
					<td class="vertical-align-middle font-12">
						{{ $address->address1 }} <br/>
						{{ $address->address2 }} <br/>
						{{ $address->county }}, {{ $address->city }}
					</td>
					<td class="vertical-align-middle">{{ $address->mobile_phone }}</td>
					<td class="vertical-align-middle">{{ $address->comment }}</td>
					<td class="vertical-align-middle">
						<a href="javascript:void(0)" data-address-id="{{ $address->id }}" class="btn btn-xs btn-default btn-delete-address">
							<i class="fa fa-trash"></i> {{ __('common.delete') }}
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<div class="alert alert-info">
		{{ __('address.no_addresses') }}
	</div>
@endif
