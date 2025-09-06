<form method="{{ strtolower($method) === 'get' ? 'get' : 'post' }}" action="{{ $action }}" class="{{ $class }}">
    @csrf
    @method($method)
    {{ $slot }}
</form>