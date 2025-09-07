<x-layouts.main :title="$shop->name">
   <a href="{{ route('shops.index') }}">Back to list</a>
   <hr>
   @forelse ($shop->products as $product)
       <table>
         <thead>
            <th>Имя</th>
            <th>Цена</th>
         </thead>
        <tbody>
               <tr>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->pivot->price }}</td>
                  <td>
                     <x-form.form method="delete" action="{{ route('shops.destroy', $product->id) }}">
                           <button type="submit">Delete</button>
                     </x-form.form>
                  </td>
               </tr>
        </tbody>
    </table>
   @empty
       <p>Нет продуктов</p>
   @endforelse
</x-layouts.main>