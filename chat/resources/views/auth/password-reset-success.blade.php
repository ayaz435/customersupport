<x-guest-layout>
    <div class="row">
        <center>
            <div class="col-sm-12 col-md-4 col-lg-4"></div>
            <div class="py-5 col-sm-12 col-md-4 col-lg-4 rounded-3" style="background-color:#4bb750;">
                <img class="mx-2 mb-4" src="{{ asset('img/png.png') }}" width="35%" alt="Logo">
                <div class="row">
                    <div class="col-sm-12">
                        <span class="text-light fs-3">Password Reset Successful</span>
                        <div class="mt-4">
                            <p class="text-light">
                                {{ $message ?? 'Your password has been successfully updated.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </div>
</x-guest-layout>
