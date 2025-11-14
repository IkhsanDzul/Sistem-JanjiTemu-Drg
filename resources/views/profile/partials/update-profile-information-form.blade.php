<section class="space-y-6">

    <h2 class="text-lg font-medium text-white">
        {{ __('Update Profile Information') }}
    </h2>

    <p class="mt-1 text-sm text-gray-300">
        {{ __('Update your account\'s profile information and email address.') }}
    </p>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
        class="mt-6 space-y-6 w-full">
        @csrf
        @method('patch')

        <!-- Grid responsif: 1 kolom di HP, 2 kolom di layar besar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="space-y-4">

                <!-- Foto -->
                <div>
                    <x-input-label for="foto_profil" :value="__('Foto Profil')" />
                    <div class="my-2 flex justify-center md:justify-center">
                        <img src="{{ asset('storage/' . $user->foto_profil) }}"
                            alt="Foto Profil"
                            class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover shadow-md">
                    </div>

                    <x-text-input id="foto_profil" name="foto_profil" type="file" accept="image/*"
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('foto_profil')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nik" :value="__('NIK')" />
                    <x-text-input id="nik" name="nik" type="text"
                        class="mt-1 block w-full"
                        :value="old('nik', $user->nik)" required autocomplete="nik" />
                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="alamat" :value="__('Alamat')" />
                    <x-text-input id="alamat" name="alamat" type="text"
                        class="mt-1 block w-full"
                        :value="old('alamat', $user->alamat)" required autocomplete="alamat" />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                    <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date"
                        class="mt-1 block w-full"
                        :value="old('tanggal_lahir', $user->tanggal_lahir)" required autocomplete="tanggal_lahir" />
                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                    <select id="jenis_kelamin" name="jenis_kelamin"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#005248] focus:border-[#005248]">
                        <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                </div>

            </div>

            <div class="space-y-4">

                <div>
                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                    <x-text-input id="nama_lengkap" name="nama_lengkap" type="text"
                        class="mt-1 block w-full"
                        :value="old('nama_lengkap', $user->nama_lengkap)" required autofocus autocomplete="nama_lengkap" />
                    <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email"
                        class="mt-1 block w-full"
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nomor_telp" :value="__('No Telepon')" />
                    <x-text-input id="nomor_telp" name="nomor_telp" type="number"
                        class="mt-1 block w-full"
                        :value="old('nomor_telp', $user->nomor_telp)" required autocomplete="nomor_telp" />
                    <x-input-error :messages="$errors->get('nomor_telp')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="golongan_darah" :value="__('Golongan Darah')" />
                    <x-text-input id="golongan_darah" name="golongan_darah" type="text"
                        class="mt-1 block w-full"
                        :value="old('Isi Data Golongan Darah' ?? 'golongan_darah', $pasien->golongan_darah)" required autocomplete="golongan_darah" />
                    <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="alergi" :value="__('Alergi')" />
                    <x-text-input id="alergi" name="alergi" type="text"
                        class="mt-1 block w-full"
                        :value="old('Isi Data Alergi' ?? 'alergi', $pasien->alergi ?? 'Tidak Ada')" required autocomplete="alergi" />
                    <x-input-error :messages="$errors->get('alergi')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="riwayat_penyakit" :value="__('Riwayat Penyakit')" />
                    <x-text-input id="riwayat_penyakit" name="riwayat_penyakit" type="text"
                        class="mt-1 block w-full"
                        :value="old('Isi Data Riwayat Penyakit' ?? 'riwayat_penyakit', $pasien->riwayat_penyakit)" required autocomplete="riwayat_penyakit" />
                    <x-input-error :messages="$errors->get('riwayat_penyakit')" class="mt-2" />
                </div>

            </div>
        </div>

        <!-- Tombol Save -->
        <div>
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-200 mt-2">
                {{ __('Saved.') }}
            </p>
            @endif
        </div>
    </form>

</section>