export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface IFlash {
    message: {
        title: string;
        icon: 'success' | 'error' | 'warning' | 'info' | 'question';
    };
}

export interface IAccount {
    id: string;
    Account_Name: string;
    Phone: string;
    Website: string;
}

export interface IDeal {
    id: string;
    Deal_Name: string;
    Stage: string;
    Account_Name: {
        id: string;
        name: string;
    };
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
