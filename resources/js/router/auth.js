import Login from '../pages/auth/Login';
import ResetPassword from "../pages/auth/ResetPassword";
import ForgotPassword from "../pages/auth/ForgotPassword";
import CheckEmail from "../pages/auth/CheckEmail";
import RegisterForm from "../pages/auth/RegisterForm";
import QuestionForm from "../pages/auth/QuestionForm";

const meta = { auth: false };

export const routes = [
    {
        name: 'Login',
        path: '/login',
        component: Login,
        meta: meta
    },
    {
        name: 'Register',
        path: '/register',
        component: RegisterForm,
        meta: meta
    },
    {
        name: 'Registration',
        path: '/registration',
        component: QuestionForm,
    },
    {
        name: 'ResetPassword',
        path: '/reset-password',
        component: ResetPassword
    },
    {
        name: 'ForgotPassword',
        path: '/forgot-password',
        component: ForgotPassword
    },
    {
        name: 'CheckEmail',
        path: '/check-email/:email',
        component: CheckEmail,
    }
];
