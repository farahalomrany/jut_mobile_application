

                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>

                            <tr>
                            
                               
                                <th class="text-center">Name</th>
                               
                                <th class="text-center">Description</th>
                          
                            </tr>

                        </thead>

                        <tbody>
                        @foreach($allGifts  as $gift)
                            <tr>
                               

                                <td class="text-center">{{ $gift->name }}</td>
                               
                                <td class="text-center">{{ $gift->description }}</td>

                               

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
  
 


