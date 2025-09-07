<x-layouts.main title="Shops list">
    <hr>
    <table class="table table-bordered table-hover">
        <tbody>
            @foreach($shops as $shop)
                <tr>
                    <td>{{ $shop->name }}</td>
                    <td>
                        <a href="{{ route('shops.show', [ $shop->id ]) }}">Read more</a> |
                    </td>
                     <td>
                        <x-form.form method="delete" action="{{ route('categories.destroy', $shop->id) }}">
                            <button type="submit">Delete</button>
                        </x-form.form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.main>