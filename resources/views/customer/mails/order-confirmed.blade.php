<x-mail::message>
    <h2>
        Your Order will be soon picked up by {{ $order->deliveryPersonnel->name }}
    </h2>
#Order summary
    <x-mail::table>
        | Charges       | Price                                 |
        |:-------------:| --------:                             |
        | Order Total   | ${{$order->total_amount}}             |
        | Platform fee  | $2                                    |
        | total         |${{$order->total_amount+2}}            |
    </x-mail::table>

Thanks,<br>
Bite Buddy
</x-mail::message>
