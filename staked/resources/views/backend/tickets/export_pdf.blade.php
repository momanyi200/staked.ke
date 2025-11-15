<h2>Tickets Report</h2>
<p><strong>Period:</strong> {{ $period }}</p>

<p><strong>Total Deposit:</strong> KSh {{ number_format($totals['deposit'], 2) }}</p>
<p><strong>Total Staked:</strong> {{ number_format($totals['spent'],2) }}</p>
<p><strong>Total Return:</strong> {{ number_format($totals['return'],2) }}</p>
<p><strong>Total Profit:</strong> {{ number_format($totals['profit'],2) }}</p>
<br>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Stake</th>
            <th>Total Odds</th>
            <th>Return</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->date }}</td>
            <td>{{ $t->total_stake }}</td>
            <td>{{ $t->total_odds }}</td>
            <td>{{ $t->total_return }}</td>
            <td>{{ $t->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
