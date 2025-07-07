<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
	<input type="hidden" id="comments_permission" value="{{ checkIfUserHasThisPermission(Session::get('projectID') , 'review_documents') }}"/>

    @include('metsl.pages.widgets.correspondence')
        @include('metsl.pages.widgets.documents')
    @include('metsl.pages.widgets.meetings_planned')

    @include('metsl.pages.widgets.meetings')
    @include('metsl.pages.widgets.documents')
    @include('metsl.pages.widgets.punchlist')

    @include('metsl.pages.documents.comments')



</div>