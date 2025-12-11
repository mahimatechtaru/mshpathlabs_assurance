<html>
    <head>
        <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        </style>
    </head>
    <body>
        <table>
            @foreach (json_decode($medicineName) as $item)
                <tr>
                    <td>{{ $item->medicine }}</td>
                    <td>{{ $item->days }}</td>
                    <td>
                        {{$item->morning == 1 ? 1 : 0}}&nbsp;&nbsp;
                        {{$item->afternoon == 1 ? 1 : 0}}&nbsp;&nbsp;
                        {{$item->night == 1 ? 1 : 0}}
                    </td>
                </tr>
            @endforeach
            <tr>
                <th>Medicine name</th>
                <th>Days</th>
                <th>Frequency</th>
            <tr>
        </table>
    </body>
</html>
