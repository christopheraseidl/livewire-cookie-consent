<div>
    @if (file_exists(public_path('christopheraseidl/cookie-consent/images/x.svg')))
        {!! file_get_contents(public_path('christopheraseidl/cookie-consent/images/x.svg')) !!}
    @else
        X
    @endif
</div>