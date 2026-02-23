<details class="border-b border-gray-900/10 bg-gray-100 p-5 rounded-md" open>
    <summary class="text-xl font-semibold text-gray-900 bg-gray-100 border-b border-gray-300 pb-2">Create a Domain</summary>
    <div class="notifications">
        <?php foreach ($errors as $error) { ?>
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 mb-2 mt-2" role="alert">
                <p><?php echo $error; ?></p>
            </div>
        <?php }
        if ($success) { ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="success">
                <p>Domain created successfully!</p>
            </div>
        <?php } ?>
    </div>
    <form class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6" id="domainForm" method="post" action="/create">
        <div class="col-span-full">
            <label for="domain" class="block text-sm/6 font-medium text-gray-900">Domainname</label>
            <div class="mt-2">
                <input
                        type="text"
                        id="domain"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        name="domain"
                        placeholder="example.com"
                        required
                        pattern="[a-zA-Z0-9]([a-zA-Z0-9\-]*[a-zA-Z0-9])?(\.[a-zA-Z]{2,})"
                >
                <span class="text-sm text-gray-500">e.g. example.com</span>

            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="ftp_username" class="block text-sm/6 font-medium text-gray-900">FTP Username</label>
            <div class="mt-2">
                <input
                        type="text"
                        id="ftp_username"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        name="ftp_username"
                        placeholder="ftpuser"
                        required
                >
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="ftp_password" class="block text-sm/6 font-medium text-gray-900">FTP Password</label>
            <div class="mt-2">
                <input
                        type="password"
                        id="ftp_password"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        name="ftp_password"
                        placeholder="********"
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}"
                        minlength="8"
                        required
                >
                <span class="text-sm text-gray-500">Min 8 characters with at least one uppercase letter, one lowercase letter, and one digit.</span>
            </div>
        </div>

        <input type="hidden" id="nonce" name="nonce" value="<?php echo htmlspecialchars($_SESSION['nonce'] ?? ''); ?>">

        <div class="col-span-full flex items-center justify-end">
            <button type="submit" class="flex w-max gap-4 items-center cursor-pointer rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <div role="status" class="text-center w-full flex justify-center w-max gap-4 hidden">
                    <svg aria-hidden="true" class="w-6 h-6 text-neutral-tertiary animate-spin fill-brand" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="white"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="black"/>
                    </svg>
                </div>
                Create Domain</button>
        </div>

    </form>
</details>
