import Participants from "../pages/Participants";

const meta = { auth: true, role: 'admin' };

export const routes = [
    {
        name: 'Home',
        path: '/',
        component: Participants,
        meta: meta
    }
];
