<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @forelse (auth()->user()->clients as $client)
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul>
                        <li><strong>ID:</strong> {{ $client->id }}</li>
                        <li><strong>Name:</strong> {{ $client->name }}</li>
                        <li><strong>Secret:</strong> {{ $client->secret }}</li>
                        <li><strong>Redirect:</strong> {{ $client->redirect }}</li>
                    </ul>
                </div>
                @empty
                    <div class="p-6 bg-white border-b border-gray-200">
                        You don't have any clients!
                    </div>
                @endforelse
            </div>



        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="w-full max-w-xs">
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-8">
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="application_name">
                        Application Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required id="app_name" type="text" placeholder="Application Name">
                  </div>
                  <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="redirect_url">
                      Redirect Url
                    </label>
                    <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" required id="redirect_url" type="text" placeholder="Redirect Url">
                  </div>
                  <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" onclick="add_token()">
                      Generate Key
                    </button>
                  </div>
                </form>
              </div>

        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>

function add_token()
{
    var app_name = $('#app_name').val();
    var redirect_url = $('#redirect_url').val();

    if(app_name == "" || redirect_url == "")
    {
        alert('Kindly Fill the data');
        return;
    }
    else
    {
        const data = {
            name: app_name,
            redirect: redirect_url,
            "_token": "{{ csrf_token() }}",
        };

        $.post('/oauth/clients', data)
            .then(response => {
                window.location.href = "/dashboard";
                console.log(response.data);
            })
            .catch (response => {
                // List errors on response...
            });
    }
}

</script>
