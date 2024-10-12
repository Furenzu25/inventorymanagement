<div class="text-gray-200">
    <h3 class="text-lg font-semibold mb-4">{{ $title }}</h3>
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                @if(!$sale)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Sale ID</th>
                @endif
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Amount Paid</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Due Amount</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-700">
            @foreach($payments as $payment)
                <tr class="hover:bg-gray-800 transition-colors duration-200">
                    @if(!$sale)
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('payments.history', $payment->sale_id) }}" class="text-indigo-400 hover:text-indigo-300">
                                {{ $payment->sale_id }}
                            </a>
                        </td>
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payment->payment_date->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($payment->amount_paid, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($payment->due_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
