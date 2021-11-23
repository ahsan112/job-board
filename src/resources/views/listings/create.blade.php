<x-app-layout>
    <section class="overflow-hidden text-gray-600 ">
        <div class="w-full py-24 mx-auto md:w-1/2">
            <div class="mb-4">
                <h2 class="text-2xl font-medium text-gray-900">
                    Create a new listing ($99)
                </h2>
            </div>
            @if ($errors->any())
                    <div class="font-medium text-red-600">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>
                    <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" 
                action="{{ route('listings.store') }}"
                id="payment_form"
                enctype="multipart/form-data"
                class="p-4 bg-gray-100 "
            >
                @csrf

                @guest                    
                    <div class="flex mb-4">
                        <div class="flex-1 mx-2">
                            <x-label for="email" value="Email Address" />
                            <x-input 
                                id="email" 
                                type="email" 
                                name="email"  
                                :value="old('email')"
                                class="block w-full mt-1"
                                required
                                autofocus />
                        </div>
                        <div class="flex-1 mx-2">
                            <x-label for="name" value="Name" />
                            <x-input 
                                id="name" 
                                type="text" 
                                name="name"  
                                :value="old('name')"
                                class="block w-full mt-1"
                                required />
                        </div>
                    </div>
                    <div class="flex mb-4">
                        <div class="flex-1 mx-2">
                            <x-label for="password" value="Password" />
                            <x-input 
                                id="password" 
                                type="password" 
                                name="password"  
                                class="block w-full mt-1"
                                required />
                        </div>
                        <div class="flex-1 mx-2">
                            <x-label for="password_confirmation" value="Password Confirmation" />
                            <x-input 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation"  
                                class="block w-full mt-1"
                                required />
                        </div>
                    </div>
                @endguest
                    <div class="mx-2 mb-4">
                        <x-label for="title" value="Job Title" />
                        <x-input
                            id="title"
                            class="block w-full mt-1"
                            type="text"
                            name="title"
                            required />
                    </div>
                    <div class="mx-2 mb-4">
                        <x-label for="company" value="Company Name" />
                        <x-input
                            id="company"
                            class="block w-full mt-1"
                            type="text"
                            name="company"
                            required />
                    </div>
                    <div class="mx-2 mb-4">
                        <x-label for="logo" value="Company Logo" />
                        <x-input
                            id="logo"
                            class="block w-full mt-1"
                            type="file"
                            name="logo" />
                    </div>
                    <div class="mx-2 mb-4">
                        <x-label for="location" value="Location (e.g. Remote, United States)" />
                        <x-input
                            id="location"
                            class="block w-full mt-1"
                            type="text"
                            name="location"
                            required />
                    </div>
                    <div class="mx-2 mb-4">
                        <x-label for="apply_link" value="Link To Apply" />
                        <x-input
                            id="apply_link"
                            class="block w-full mt-1"
                            type="text"
                            name="apply_link"
                            required />
                    </div>
                    <div class="mx-2 mb-4">
                        <x-label for="tags" value="Tags (separate by comma)" />
                        <x-input
                            id="tags"
                            class="block w-full mt-1"
                            type="text"
                            name="tags" />
                    </div>
                    <div class="mx-2 mb-4">
                        <x-label for="content" value="Listing Content (Markdown is okay)" />
                        <textarea
                            id="content"
                            rows="8"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            name="content"
                        ></textarea>
                    </div>
                    <div class="mx-2 mb-4">
                        <label for="is_highlighted" class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input
                                type="checkbox"
                                id="is_highlighted"
                                name="is_highlighted"
                                value="Yes"
                                class="text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2">Highlight this post (extra $19)</span>
                        </label>
                    </div>
                    <div class="mx-2 mb-6">
                        <div id="card-element"></div>
                    </div>
                    <div class="mx-2 mb-2">
                        <input
                            type="hidden"
                            id="payment_method_id"
                            name="payment_method_id"
                            value="">
                        <button type="submit" id="form_submit" class="items-center block w-full py-2 mt-4 text-base text-white bg-indigo-500 border-0 rounded focus:outline-none hover:bg-indigo-600 md:mt-0">Pay + Continue</button>
                    </div>         
            </form>
        </div>
    </section>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            classes: {
                base: 'StripeElement rounded-md shadow-sm bg-white px-2 py-3 border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full'
            }
        });

        cardElement.mount('#card-element');

        document.getElementById('form_submit').addEventListener('click', async (e) => {
            e.preventDefault()

            const {paymentMethod, error} = await stripe.createPaymentMethod(
                'card', cardElement, {}
            );

            if(error) {
                alert(error.message)
            } else {
                document.getElementById('payment_method_id').value = paymentMethod.id;
                document.getElementById('payment_form').submit(); 
            }
        })
    </script>
</x-app-layout>