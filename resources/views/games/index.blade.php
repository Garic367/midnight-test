@extends('layouts.app')

@section('content')
    <h1>Game Rankings</h1>
    <table>
        <thead>
        <tr>
            <th>TITLE</th>
            <th>US POSITION</th>
            <th>UK POSITION</th>
            <th>DE POSITION</th>
            <th>JP POSITION</th>
            <th>RELEASE DATE</th>
            <th>PUBLISHER</th>
            <th>GENRE</th>
            <th>RATING</th>
            <th>TOTAL NUMBER OF RATINGS</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($games as $game)
            <tr>
                <td>{{ $game->name }}</td>
                <td>{{ $game->us_position }}</td>
                <td>{{ $game->gb_position }}</td> <!-- Обратите внимание на gb_position -->
                <td>{{ $game->de_position }}</td>
                <td>{{ $game->jp_position }}</td>
                <td>{{ $game->release_date }}</td>
                <td>{{ $game->publisher }}</td>
                <td>{{ $game->genres }}</td>
                <td>{{ $game->average_rating }}</td>
                <td>{{ number_format($game->reviews_count) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

