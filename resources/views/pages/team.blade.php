@extends('layouts.main')

@section('title',$team->team_name)

@section('content')
<section class="team-content shadow-sm">
    <div class="team-header">
        <img class="p-2" src="/img/shields/{{$team->team_img}}.png" alt="{{$team->team_img}}" width="90">
        <h1>{{$team->team_name}}</h1>
        <p><img src="/img/flags/{{$team->league->league_country_flag}}.png" alt="{{$team->league->league_country_flag}}" width="25">{{$team->league->league_country}}</p> 
    </div>
    <div class="row">
        <div class="col">
            <h2>Half-Time Statistics</h2>
            <div class="table-results">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Wins</th>
                            <th>Draws</th>
                            <th>Loses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Overall</td>
                            <td>{{$team->home_ht['wins']+$team->away_ht['wins']}}</td>
                            <td>{{$team->home_ht['draws']+$team->away_ht['draws']}}</td>
                            <td>{{$team->home_ht['loses']+$team->away_ht['loses']}}</td>
                        </tr>
                        <tr>
                            <td>Home</td>
                            <td>{{$team->home_ht['wins']}}</td>
                            <td>{{$team->home_ht['draws']}}</td>
                            <td>{{$team->home_ht['loses']}}</td>
                        </tr>
                        <tr>
                            <td>Away</td>
                            <td>{{$team->away_ht['wins']}}</td>
                            <td>{{$team->away_ht['draws']}}</td>
                            <td>{{$team->away_ht['loses']}}</td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="table-scores">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>GF</th>
                            <th>GA</th>
                            <th>AVG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Overall</td>
                            <td>{{$team->goalavght['gf_total']}}</td>
                            <td>{{$team->goalavght['ga_total']}}</td>
                            <td>{{$team->goalavght['gf_total']+$team->goalavght['ga_total']}}</td>
                        </tr>
                        <tr>
                            <td>Home</td>
                            <td>{{$team->goalavght['gf_home']}}</td>
                            <td>{{$team->goalavght['ga_home']}}</td>
                            <td>{{$team->goalavght['gf_home']+$team->goalavght['ga_home']}}</td>
                        </tr>
                        <tr>
                            <td>Away</td>
                            <td>{{$team->goalavght['gf_away']}}</td>
                            <td>{{$team->goalavght['ga_away']}}</td>
                            <td>{{$team->goalavght['gf_away']+$team->goalavght['ga_away']}}</td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="2"><i class="fas fa-futbol"></i>Over 0.5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$team->gl05['ht']}}%</td>
                                <td>{{$team->gl05['ft']}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="2"><i class="fas fa-futbol"></i>Over 1.5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$team->gl15['ht']}}%</td>
                                <td>{{$team->gl15['ft']}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="2"><i class="fas fa-futbol"></i>AVG goals</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$team->goalavght['gf_total']+$team->goalavght['ga_total']}}</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bts-table">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>BTS</th>
                            <th>First time</th>
                            <th>Second time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Yes</td>
                            <td>{{$team->btsht['yes']}}%</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>{{$team->btsht['no']}}%</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col">
            <h2>Full-Time Statistics</h2>
            <div class="table-results">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Wins</th>
                            <th>Draws</th>
                            <th>Loses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Overall</td>
                            <td>{{$team->home_ft['wins']+$team->away_ft['wins']}}</td>
                            <td>{{$team->home_ft['draws']+$team->away_ft['draws']}}</td>
                            <td>{{$team->home_ft['loses']+$team->away_ft['loses']}}</td>
                        </tr>
                        <tr>
                            <td>Home</td>
                            <td>{{$team->home_ft['wins']}}</td>
                            <td>{{$team->home_ft['draws']}}</td>
                            <td>{{$team->home_ft['loses']}}</td>
                        </tr>
                        <tr>
                            <td>Away</td>
                            <td>{{$team->away_ft['wins']}}</td>
                            <td>{{$team->away_ft['draws']}}</td>
                            <td>{{$team->away_ft['loses']}}</td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="table-scores">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>GF</th>
                            <th>GA</th>
                            <th>AVG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Overall</td>
                            <td>{{$team->goalavgft['gf_total']}}</td>
                            <td>{{$team->goalavgft['ga_total']}}</td>
                            <td>{{$team->goalavgft['gf_total']+$team->goalavgft['ga_total']}}</td>
                        </tr>
                        <tr>
                            <td>Home</td>
                            <td>{{$team->goalavgft['gf_home']}}</td>
                            <td>{{$team->goalavgft['ga_home']}}</td>
                            <td>{{$team->goalavgft['gf_home']+$team->goalavgft['ga_home']}}</td>
                        </tr>
                        <tr>
                            <td>Away</td>
                            <td>{{$team->goalavgft['gf_away']}}</td>
                            <td>{{$team->goalavgft['ga_away']}}</td>
                            <td>{{$team->goalavgft['gf_away']+$team->goalavgft['ga_away']}}</td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th><i class="fas fa-futbol"></i>Over 1.5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$team->ft15['ht']}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th><i class="fas fa-futbol"></i>Over 2.5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$team->ft25['ht']}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th><i class="fas fa-futbol"></i>AVG goals</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$team->goalavgft['gf_total']+$team->goalavgft['ga_total']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bts-table">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2">BTS Full-time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Yes</td>
                            <td>{{$team->btsft['yes']}}%</td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>{{$team->btsft['no']}}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="corner-team">
        <h3>Corners market</h3>
        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2">Over corners</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['over_corner'] as $corner)
                        <tr>
                            <td>{{$corner['name']}}</td>
                            <td>{{$corner['over']}}%</td>
                        </tr>
                    @endforeach    
                    </tbody>
                </table>
            </div>
            <div class="col">
            <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2">Corners for</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['corner_for'] as $cornerfor)
                        <tr>
                            <td>{{$cornerfor['name']}}</td>
                            <td>{{$cornerfor['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>            
            </div>
            <div class="col">
            <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2">Corners against</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['corner_against'] as $cornerag)
                        <tr>
                            <td>{{$cornerag['name']}}</td>
                            <td>{{$cornerag['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>            
            </div>
        </div>
    </div>
    <div class="card-team">
        <h3>Cards market</h3>
        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2">Over cards</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['over_card'] as $card)
                        <tr>
                            <td>{{$card['name']}}</td>
                            <td>{{$card['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col">
            <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2">Cards received</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['card_for'] as $cardfor)
                        <tr>
                            <td>{{$cardfor['name']}}</td>
                            <td>{{$cardfor['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>            
            </div>
            <div class="col">
            <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2">Cards oponent</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['card_against'] as $cardaga)
                        <tr>
                            <td>{{$cardaga['name']}}</td>
                            <td>{{$cardaga['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>            
            </div>
        </div>
    </div>
</section>
@endsection