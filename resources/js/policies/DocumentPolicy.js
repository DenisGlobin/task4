export default class DocumentPolicy
{
    static create(user)
    {
        if (typeof user !== 'undefined') {
            return true;
        } else {
            return false;
        }
    }

    static view(user, document)
    {
        if (document.status === 'published' || ((typeof user !== 'undefined') && user.id === document.user_id)) {
            // Allow the user to view the document
            return true;
        } else {
            return false;
        }
    }

    static update(user, document)
    {
        if (user.id === document.owner.id) {
            if (document.status === 'draft') {
                // Allow the user to edit the document
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}