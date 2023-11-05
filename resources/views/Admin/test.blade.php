
                      <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                                    <thead>
                                                    <tr>
                                                        <th data-priority="1">Employee ID</th>
                                                      
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    
                             @php
                             $campaigns = \App\Models\Campaign::all();
                           
                             @endphp
                                                        @foreach( $campaigns as $campaign)

                                                        <tr>
                                                            <td>{{$campaign->id}}</td>
                                                           
                                            
                                                        </tr>
                                                        @endforeach
                                                   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->    
                                    
