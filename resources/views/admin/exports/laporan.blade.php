<table>
    <thead>
        <tr>
            <th>Category</th>
            @foreach($months as $m)
                <th>{{ $m }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($incomeCats as $cat)
            <tr>
                <td>{{ $cat }}</td>
                @foreach($months as $m)
                    <td>{{ $pivot[$cat][$m] ?? 0 }}</td>
                @endforeach
            </tr>
        @endforeach

        <tr>
            <td>Total Income</td>
            @foreach($months as $m)
                <td>{{ $totals['income'][$m] }}</td>
            @endforeach
        </tr>

        @foreach($expenseCats as $cat)
            <tr>
                <td>{{ $cat }}</td>
                @foreach($months as $m)
                    <td>{{ $pivot[$cat][$m] ?? 0 }}</td>
                @endforeach
            </tr>
        @endforeach

        <tr>
            <td>Total Expense</td>
            @foreach($months as $m)
                <td>{{ $totals['expense'][$m] }}</td>
            @endforeach
        </tr>

        <tr>
            <td>Net Income</td>
            @foreach($months as $m)
                <td>{{ $totals['net'][$m] }}</td>
            @endforeach
        </tr>
    </tbody>
</table>
