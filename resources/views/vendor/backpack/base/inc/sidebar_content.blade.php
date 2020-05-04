<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ __('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('categories') }}'><i class='nav-icon fa fa-question'></i> {{ __('category.categories') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('products') }}'><i class='nav-icon fa fa-question'></i> {{ __('product.products') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('orders') }}'><i class='nav-icon fa fa-question'></i> {{ __('order.orders') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('clients') }}'><i class='nav-icon fa fa-question'></i> {{ __('client.clients') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('attributes') }}'><i class='nav-icon fa fa-question'></i> {{ __('attribute.attributes') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('attributes-sets') }}'><i class='nav-icon fa fa-question'></i> {{ __('attribute.attribute_sets') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('currencies') }}'><i class='nav-icon fa fa-question'></i> {{ __('currency.currencies') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('carriers') }}'><i class='nav-icon fa fa-truck'></i> {{ __('carrier.carriers') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('taxes') }}'><i class='nav-icon fa fa-balance-scale'></i> {{ __('tax.taxes') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('order-statuses') }}'><i class='nav-icon fa fa-list-ul'></i> {{ __('order.order_statuses') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('cart-rules') }}'><i class='nav-icon fa fa-shopping-cart'></i> {{ __('cartrule.cart_rules') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('notification-templates') }}'><i class='nav-icon fa fa-list'></i> {{ __('notification_templates.notification_templates') }}</a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-group"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>{{ __('user.users') }}</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon fa fa-group"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
