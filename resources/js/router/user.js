import QuestionForm from "../pages/auth/QuestionForm";
import Participants from "../pages/Participants";
import Manage from "../pages/Manage";
import Outreach from "../pages/Outreach";
import Design from "../pages/Design";
import Campaigns from "../pages/plan/Campaigns/All";
import ContentStudio from "../pages/plan/ContentStudio";
import Insights from "../pages/plan/Insights";
import Screening from "../pages/plan/Screening";
import Feasibility from "../pages/plan/Feasibility";
import Communications from "../pages/recruit/communication/Communications";
import Edit from "../pages/recruit/communication/Edit";
import Overview from "../pages/recruit/Overview";
// import Participance from "../pages/recruit/Participance";
import Scraper from "../pages/recruit/Scraper";
import SelectStudy from "../pages/SelectStudy";
import CampaignsTable from "../pages/CampaignsTable";

const meta = { auth: true, role: 'user' };

export const routes = [
    {
        name: 'Home',
        path: '/',
        component: Participants,
        meta: meta
    },
    {
        name: 'Registration',
        path: '/registration',
        component: QuestionForm,
        meta: meta
    },
    {
        name: 'Manage',
        path: '/manage',
        component: Manage,
        meta: meta
    },
    {
        name: 'Outreach',
        path: '/outreach',
        component: Outreach,
        meta: meta
    },
    {
        name: 'campaigns-table',
        path: '/campaigns-table',
        component: CampaignsTable,
        meta: meta
    },
    {
        name: 'Design',
        path: '/design',
        component: Design,
        meta: meta
    },
    {
        name: 'Campaigns',
        path: '/campaigns',
        component: Campaigns,
        meta: meta
    },
    {
        name: 'ContentStudio',
        path: '/content-studio',
        component: ContentStudio,
        meta: meta
    },
    {
        name: 'Insights',
        path: '/insights',
        component: Insights,
        meta: meta
    },
    {
        name: 'Screening',
        path: '/screening',
        component: Screening,
        meta: meta
    },
    {
        name: 'Feasibility',
        path: '/feasibility',
        component: Feasibility,
        meta: meta
    },
    {
        name: 'Overview',
        path: '/overview',
        component: Overview,
        meta: meta
    },
    // {
    //     name: 'Participance',
    //     path: '/participance',
    //     component: Participance,
    //     meta: meta
    // },
    {
        name: 'Communications',
        path: '/communications',
        component: Communications,
        meta: meta
    },
    {
        name: 'Communication-edit',
        path: '/edit/:id',
        component: Edit,
        meta: meta
    },
    {
        name: 'Scraper',
        path: '/scraper',
        component: Scraper,
        meta: meta
    },
    {
        name: 'SelectStudy',
        path: '/select-study',
        component: SelectStudy,
        meta: meta
    }
];
