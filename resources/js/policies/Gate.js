import DocumentPolicy from './DocumentPolicy';

export default class Gate
{
    constructor()
    {
        this.policies = {
            document: DocumentPolicy
        };
    }

    allow(action, type, user, model = null)
    {
        return this.policies[type][action](user, model);
    }

    deny(action, type, user, model = null)
    {
        return ! this.allow(action, type, user, model);
    }
}