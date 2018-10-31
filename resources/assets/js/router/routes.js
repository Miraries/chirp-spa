const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)

const Thread = () => import('~/pages/thread').then(m => m.default || m)
const NewThread = () => import('~/pages/newthread').then(m => m.default || m)

const Messages = () => import('~/pages/messages').then(m => m.default || m)
const NewMessage = () => import('~/pages/newmessage').then(m => m.default || m)

const Profile = () => import('~/pages/profile').then(m => m.default || m)

const ServerInfo = () => import('~/pages/serverinfo').then(m => m.default || m)

export default [
    {path: '/', name: 'welcome', component: Welcome},

    {path: '/login', name: 'login', component: Login},
    {path: '/register', name: 'register', component: Register},
    {path: '/password/reset', name: 'password.request', component: PasswordEmail},
    {path: '/password/reset/:token', name: 'password.reset', component: PasswordReset},

    {path: '/home', name: 'home', component: Home},
    {
        path: '/settings',
        component: Settings,
        children: [
            {path: '', redirect: {name: 'settings.profile'}},
            {path: 'profile', name: 'settings.profile', component: SettingsProfile},
            {path: 'password', name: 'settings.password', component: SettingsPassword}
        ]
    },

    {path: '/threads/create', name: 'newthread', component: NewThread},
    {path: '/threads/:id', name: 'thread', component: Thread},

    {path: '/dm/', name: 'conversations', component: Messages},
    {path: '/dm/create', name: 'newmessage', component: NewMessage},
    {path: '/dm/:id', name: 'messages', component: Messages},

    {path: '/profile', name: 'profile.self', component: Profile},
    {path: '/profile/:id', name: 'profile.user', component: Profile},

    {path: '/serverinfo', name: 'serverinfo', component: ServerInfo},

    {path: '*', component: NotFound}
]
