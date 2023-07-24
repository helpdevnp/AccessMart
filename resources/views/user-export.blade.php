<div class="row">
    <div class="col-lg-12"><h1 style="color: red">wertywe reru yewtru ryewtru ewtr</h1></div>
    <div class="col-lg-12">

        <div><p>dtewfywtef</p><h1>gduewgf</h1></div>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->f_name }}
                <br>
            {{ $user->phone }}</td>
                <td>{{ $user->email }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>