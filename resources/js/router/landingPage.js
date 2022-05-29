import LandingPage from "../pages/LandingPage";

const meta = { auth: true, role: 'user' };

export const routes = [
    {
        name: 'Landing page',
        path: '/landing-page/:id',
        component: LandingPage,
        meta: meta
    }
]
