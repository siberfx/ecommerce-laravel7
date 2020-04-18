@extends('backpack::blank')

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <a href="javascript: window.print();" class="btn float-right"><i class="fa fa-print"></i></a>
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
            @if ($crud->hasAccess('list'))
                <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">
                        <span><i class="fa fa-ticket"></i> {{ __('order.order_status') }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <h4>
                        Current status <br><br>
                        <span class="label label-default">{{ $order->status->name }}</span>
                    </h4>

                    <hr>

                    <h4>
                        Status history
                    </h4>
                    @if (count($order->statusHistory) > 0)
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>{{ __('order.status') }}</th>
                                <th>{{ __('common.date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->statusHistory as $statusHistory)
                                <tr>
                                    <td>{{ $statusHistory->status->name }}</td>
                                    <td>{{ $statusHistory->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            {{ __('order.no_status_history') }}
                        </div>
                    @endif

                    <hr>

                    @if (count($orderStatuses) > 0)
                        <form action="{{ route('updateOrderStatus') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            <div class="form-group">
                                <select name="status_id" id="status_id" class="select2_field" style="width: 100%">
                                    @foreach($orderStatuses as $orderStatus)
                                        <option value="{{ $orderStatus->id }}">{{ $orderStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('order.update_status') }}</button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            {{ __('order.no_order_statuses') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">
                        <span><i class="fa fa-user"></i> {{ __('client.client') }}</span>
                    </h3>
                </div>

                <div class="card-body">
                    <div class="col-md-12 well">
                        <div class="col-md-6">
                            <i class="fa fa-user-circle-o"></i> {{ $order->user->name }} <br/>
                            <i class="fa fa-envelope"></i> <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a> <br/>
                        </div>
                        <div class="col-md-6">
                            <i class="fa fa-birthday-cake"></i> {{ $order->user->birthday ? $order->user->birthday.' ('.$order->user->age().' '.strtolower(__('common.years')).')': '-' }}
                            <br>
                            {!! ($order->user->gender == 1) ? '<i class="fa fa-mars"></i> '.__('user.male') : '<i class="fa fa-venus"></i> '.__('user.female') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">
                        <span><i class="fa fa-user"></i> {{ __('order.shipping_details') }}</span>
                    </h3>
                </div>

                <div class="card-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-pills nav-fill">

                            <li class="nav-item">
                                <a class="nav-link active" href="#tab-shipping-address" data-toggle="tab">{{ __('order.shipping_address') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#tab-billing-info" data-toggle="tab">{{ __('order.billing_info') }}</a>
                            </li>
                        </ul>
                        @if ($order->shippingAddress)
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-shipping-address">
                                    <h4>{{ __('order.shipping_address') }}</h4>
                                    <table class="table table-condensed table-hover">
                                        <tr>
                                            <td>{{ __('address.contact_person') }}</td>
                                            <td>{{ $order->shippingAddress->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('address.address') }}</td>
                                            <td>
                                                {{ $order->shippingAddress->address1 }} <br>
                                                {{ $order->shippingAddress->address2 }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('address.county') }}</td>
                                            <td>{{ $order->shippingAddress->county }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('address.city') }}</td>
                                            <td>{{ $order->shippingAddress->city }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('address.postal_code') }}</td>
                                            <td>{{ $order->shippingAddress->postal_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('address.phone') }}</td>
                                            <td>{{ $order->shippingAddress->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('address.mobile_phone') }}</td>
                                            <td>{{ $order->shippingAddress->mobile_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('address.comment') }}</td>
                                            <td>{{ $order->shippingAddress->comment }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab-billing-info">
                                    @if ($order->billingCompanyInfo)
                                        <h4>{{ __('order.billing_company_details') }}</h4>
                                        <table class="table table-condensed table-hover">
                                            <tr>
                                                <td>{{ __('company.company_name') }}</td>
                                                <td>{{ $order->billingCompanyInfo->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('company.address') }}</td>
                                                <td>
                                                    {{ $order->billingCompanyInfo->address1 }} <br>
                                                    {{ $order->billingCompanyInfo->address2 }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('company.county') }}</td>
                                                <td>{{ $order->billingCompanyInfo->county }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('company.city') }}</td>
                                                <td>{{ $order->billingCompanyInfo->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('company.tin') }}</td>
                                                <td>{{ $order->billingCompanyInfo->tin }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('company.trn') }}</td>
                                                <td>{{ $order->billingCompanyInfo->trn }}</td>
                                            </tr>
                                        </table>
                                    @endif

                                    @if ($order->billingAddress)
                                        <h4>{{ __('order.billing_address') }}</h4>
                                        <table class="table table-condensed table-hover">
                                            <tr>
                                                <td>{{ __('address.contact_person') }}</td>
                                                <td>{{ $order->billingAddress->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('address.address') }}</td>
                                                <td>
                                                    {{ $order->billingAddress->address1 }} <br>
                                                    {{ $order->billingAddress->address2 }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('address.county') }}</td>
                                                <td>{{ $order->billingAddress->county }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('address.city') }}</td>
                                                <td>{{ $order->billingAddress->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('address.postal_code') }}</td>
                                                <td>{{ $order->billingAddress->postal_code }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('address.phone') }}</td>
                                                <td>{{ $order->billingAddress->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('address.mobile_phone') }}</td>
                                                <td>{{ $order->billingAddress->mobile_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('address.comment') }}</td>
                                                <td>{{ $order->billingAddress->comment }}</td>
                                            </tr>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">
                        <span><i class="fa fa-truck"></i> {{ __('carrier.carrier') }}</span>
                    </h3>
                </div>

                <div class="card-body">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th style="width: 150px;">{{ __('carrier.logo') }}</th>
                            <th>{{ __('carrier.carrier') }}</th>
                            <th>{{ __('carrier.price') }}</th>
                            <th>{{ __('carrier.delivery_text') }}</th>
                        </tr>
                        </thead>
                        <tr>
                            <td class="vertical-align-middle">
                                <img src="{{ Storage::disk('carriers')->exists($order->carrier->logo) ? (url(config('filesystems.disks.carriers.simple_path')).'/'.$order->carrier->logo) : (url(config('filesystems.disks.carriers.simple_path')).'/default.png') }}" alt="" style="width: 100px;">
                            </td>
                            <td class="vertical-align-middle">{{ $order->carrier->name }}</td>
                            <td class="vertical-align-middle">{{ $order->carrier->price.' '.$order->currency->name }}</td>
                            <td class="vertical-align-middle">{{ $order->carrier->delivery_text }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">
                        <span><i class="fa fa-shopping-cart"></i> {{ __('product.products') }}</span>
                    </h3>
                </div>

                <div class="card-body">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>{{ __('product.product') }}</th>
                                <th>{{ __('product.price') }}</th>
                                <th>{{ __('product.price_with_tax') }}</th>
                                <th>{{ __('order.quantity') }}</th>
                                <th class="text-right">{{ __('common.total') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->products as $product)
                                <tr>
                                    <td class="vertical-align-middle">
                                        <a href="{{ url('/admin/products/'. $product->pivot->product_id.'/edit') }}">{{ $product->pivot->name }}</a><br/>
                                        <span class="font-12">SKU: {{ $product->pivot->sku }}</span>
                                    </td>
                                    <td class="vertical-align-middle">{{ decimalFormat($product->pivot->price).' '.$order->currency->name }}</td>
                                    <td class="vertical-align-middle">{{ decimalFormat($product->pivot->price_with_tax).' '.$order->currency->name }}</td>
                                    <td class="vertical-align-middle">{{ $product->pivot->quantity }}</td>
                                    <td class="vertical-align-middle text-right">{{ decimalFormat($product->pivot->price_with_tax*$product->pivot->quantity).' '.$order->currency->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6 col-md-offset-6">
                        <table class="table table-condensed">
                            <tr>
                                <td class="text-right">{{ __('order.shipping_cost') }}:</td>
                                <td class="text-right">{{ $order->carrier->price.' '.$order->currency->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>{{ __('common.total') }}:</strong></td>
                                <td class="text-right"><strong>{{ $order->total().' '.$order->currency->name }}</strong></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('after_styles')

    <!-- include select2 css-->
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Select 2 Bootstrap theme -->
    <link href="{{ asset('css/select2-bootstrap-min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('after_scripts')


    <!-- include select2 js -->
    <script src="{{ asset('packages/select2/dist/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            @if (count($orderStatuses) > 0)
            $('.select2_field').select2({
                theme: "bootstrap"
            });
            @endif
        });
    </script>
@endsection
