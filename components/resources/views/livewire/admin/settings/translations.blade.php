<div>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    
    <div class="row">
        <div class="col-12">

            <button class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#addNewLanguage"><i class="fas fa-plus fa-fw"></i> {{ __('Add New Language') }}</button>

            <div class="bg-white border-radius-lg p-3 position-sticky top-1 shadow-lg">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>{{ __('Language') }}</th>
                            <th>{{ __('Default') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>

                        @if ( !empty($languages) )

                            @foreach ($languages as $language)
                                <tr>
                                    <td>{{ $language['name'] }}</td>
                                    <td><span class="badge bg-gradient-{{ ($language['default'] == true) ? 'success' : 'secondary' }}">{{ ($language['default'] == true) ? __('Yes') : __('No') }}</span></td>
                                    <td class="w-25">
                                        <a class="btn btn-sm btn-secondary" title="{{ __('Set as Default') }}" wire:click="onSetDefault( {{ $language['id'] }} )">{{ __('Set as Default') }}</a>
                                        <a class="btn btn-sm btn-primary" title="{{ __('Translations') }}" href="{{ route('edit-translations', $language['id'] ) }}"><i class="fas fa-language fa-fw"></i> {{ __('Translations') }}</a>
                                        <a class="btn btn-sm btn-info" title="{{ __('Edit') }}" wire:click="onShowEditLanguageModal( {{ $language['id'] }} )"><i class="fas fa-edit fa-fw"></i> {{ __('Edit') }}</a>
                                        <a class="btn btn-sm btn-danger" title="{{ __('Delete') }}" wire:click="onDeleteLanguageConfirm( {{ $language['id'] }} )"><i class="fas fa-trash fa-fw"></i> {{ __('Delete') }}</a>
                                    </td>
                                </tr>
                            @endforeach

                        @endif

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Begin::Add New Language -->
    <div class="modal fade" id="addNewLanguage" tabindex="-1" role="dialog" aria-labelledby="addNewLanguageLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewLanguageModalLabel">{{ __('Add New Language') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            @livewire('admin.settings.translations.add-new-language')
          </div>

        </div>
      </div>
    </div>
    <!-- End::Add New Language -->

    <!-- Begin::Edit Language -->
    <div class="modal fade" id="editLanguage" tabindex="-1" role="dialog" aria-labelledby="editLanguageLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editLanguageModalLabel">{{ __('Edit Language') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            @livewire('admin.settings.translations.edit-language')
          </div>

        </div>
      </div>
    </div>
    <!-- End::Edit Language -->

</div>