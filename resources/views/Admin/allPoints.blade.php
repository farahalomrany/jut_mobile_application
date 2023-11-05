
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>
                            <tr>
                                <th class="text-center">Member Name</th>
                                <th class="text-center">Member Classification</th>
                                <th class="text-center">Points</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($members  as $member)
                            <tr>
                                <td class="text-center">@if($member->user){{ $member->user->fstName }}@endif</td>
                                <td class="text-center">{{ $member->classification }}</td>
                                <td class="text-center">{{ $member->count_points_for_member_in_campaign($campaign_id, $member->id) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
    
  
    
   
