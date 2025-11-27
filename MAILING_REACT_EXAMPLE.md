# Exemples React - Intégration Mailing Twilio

## 🚀 Hook personnalisé pour le Mailing

```typescript
// hooks/useMailingService.ts
import { useState } from 'react';
import axios from 'axios';

interface MailingPayload {
  event_id: number;
  subject?: string;
  body: string;
  channel: 'email' | 'sms' | 'whatsapp' | 'mms';
  type?: 'single' | 'bulk';
  recipient_type?: 'guest' | 'custom';
  recipients?: string[];
  media_urls?: string[];
  scheduled_at?: string;
}

export const useMailingService = (token: string) => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const createMailing = async (payload: MailingPayload) => {
    setLoading(true);
    setError(null);
    try {
      const response = await axios.post('/api/mailings', payload, {
        headers: { Authorization: `Bearer ${token}` },
      });
      return response.data;
    } catch (err: any) {
      const message = err.response?.data?.message || 'Erreur lors de la création';
      setError(message);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  const sendMailing = async (mailingId: number) => {
    setLoading(true);
    setError(null);
    try {
      const response = await axios.post(`/api/mailings/${mailingId}/send`, {}, {
        headers: { Authorization: `Bearer ${token}` },
      });
      return response.data;
    } catch (err: any) {
      const message = err.response?.data?.message || 'Erreur lors de l\'envoi';
      setError(message);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  const sendTestMessage = async (mailingId: number, recipient: string) => {
    setLoading(true);
    setError(null);
    try {
      const response = await axios.post(
        `/api/mailings/${mailingId}/test`,
        { recipient },
        { headers: { Authorization: `Bearer ${token}` } }
      );
      return response.data;
    } catch (err: any) {
      const message = err.response?.data?.message || 'Erreur lors du test';
      setError(message);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  const getStatistics = async (eventId: number) => {
    setLoading(true);
    setError(null);
    try {
      const response = await axios.get(
        `/api/events/${eventId}/mailings/statistics`,
        { headers: { Authorization: `Bearer ${token}` } }
      );
      return response.data;
    } catch (err: any) {
      const message = err.response?.data?.message || 'Erreur lors de la récupération';
      setError(message);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  return {
    createMailing,
    sendMailing,
    sendTestMessage,
    getStatistics,
    loading,
    error,
  };
};
```

## 📧 Composant Email

```typescript
// components/EmailForm.tsx
import React, { useState } from 'react';
import { useMailingService } from '../hooks/useMailingService';

interface EmailFormProps {
  eventId: number;
  token: string;
  onSuccess?: () => void;
}

export const EmailForm: React.FC<EmailFormProps> = ({ eventId, token, onSuccess }) => {
  const { createMailing, sendMailing, loading, error } = useMailingService(token);
  const [formData, setFormData] = useState({
    subject: '',
    body: '',
    recipients: '',
  });

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    try {
      const mailing = await createMailing({
        event_id: eventId,
        subject: formData.subject,
        body: formData.body,
        channel: 'email',
        recipients: formData.recipients.split('\n').filter(r => r.trim()),
      });

      await sendMailing(mailing.id);
      alert('Email envoyé avec succès!');
      onSuccess?.();
    } catch (err) {
      console.error(err);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div>
        <label className="block text-sm font-medium">Sujet</label>
        <input
          type="text"
          value={formData.subject}
          onChange={(e) => setFormData({ ...formData, subject: e.target.value })}
          className="w-full px-3 py-2 border rounded"
          required
        />
      </div>

      <div>
        <label className="block text-sm font-medium">Message</label>
        <textarea
          value={formData.body}
          onChange={(e) => setFormData({ ...formData, body: e.target.value })}
          className="w-full px-3 py-2 border rounded"
          rows={5}
          required
        />
      </div>

      <div>
        <label className="block text-sm font-medium">Destinataires (un par ligne)</label>
        <textarea
          value={formData.recipients}
          onChange={(e) => setFormData({ ...formData, recipients: e.target.value })}
          className="w-full px-3 py-2 border rounded"
          rows={3}
          placeholder="email1@example.com&#10;email2@example.com"
          required
        />
      </div>

      {error && <div className="text-red-600">{error}</div>}

      <button
        type="submit"
        disabled={loading}
        className="px-4 py-2 bg-blue-600 text-white rounded disabled:opacity-50"
      >
        {loading ? 'Envoi en cours...' : 'Envoyer'}
      </button>
    </form>
  );
};
```

## 📱 Composant SMS

```typescript
// components/SMSForm.tsx
import React, { useState } from 'react';
import { useMailingService } from '../hooks/useMailingService';

interface SMSFormProps {
  eventId: number;
  token: string;
  onSuccess?: () => void;
}

export const SMSForm: React.FC<SMSFormProps> = ({ eventId, token, onSuccess }) => {
  const { createMailing, sendMailing, sendTestMessage, loading, error } = useMailingService(token);
  const [formData, setFormData] = useState({
    body: '',
    recipients: '',
    testPhone: '',
  });
  const [mailingId, setMailingId] = useState<number | null>(null);

  const handleCreate = async (e: React.FormEvent) => {
    e.preventDefault();

    try {
      const mailing = await createMailing({
        event_id: eventId,
        body: formData.body,
        channel: 'sms',
        recipients: formData.recipients.split('\n').filter(r => r.trim()),
      });

      setMailingId(mailing.id);
      alert('SMS créé. Testez avant d\'envoyer!');
    } catch (err) {
      console.error(err);
    }
  };

  const handleTest = async () => {
    if (!mailingId || !formData.testPhone) return;

    try {
      await sendTestMessage(mailingId, formData.testPhone);
      alert('Message de test envoyé!');
    } catch (err) {
      console.error(err);
    }
  };

  const handleSend = async () => {
    if (!mailingId) return;

    try {
      await sendMailing(mailingId);
      alert('SMS envoyés avec succès!');
      onSuccess?.();
    } catch (err) {
      console.error(err);
    }
  };

  return (
    <form onSubmit={handleCreate} className="space-y-4">
      <div>
        <label className="block text-sm font-medium">Message SMS</label>
        <textarea
          value={formData.body}
          onChange={(e) => setFormData({ ...formData, body: e.target.value })}
          className="w-full px-3 py-2 border rounded"
          rows={3}
          maxLength={160}
          required
        />
        <p className="text-xs text-gray-500">{formData.body.length}/160</p>
      </div>

      <div>
        <label className="block text-sm font-medium">Numéros (format: +33612345678)</label>
        <textarea
          value={formData.recipients}
          onChange={(e) => setFormData({ ...formData, recipients: e.target.value })}
          className="w-full px-3 py-2 border rounded"
          rows={3}
          placeholder="+33612345678&#10;+33687654321"
          required
        />
      </div>

      {!mailingId ? (
        <>
          {error && <div className="text-red-600">{error}</div>}
          <button
            type="submit"
            disabled={loading}
            className="px-4 py-2 bg-blue-600 text-white rounded disabled:opacity-50"
          >
            {loading ? 'Création...' : 'Créer SMS'}
          </button>
        </>
      ) : (
        <div className="space-y-2">
          <div>
            <label className="block text-sm font-medium">Tester avec un numéro</label>
            <div className="flex gap-2">
              <input
                type="tel"
                value={formData.testPhone}
                onChange={(e) => setFormData({ ...formData, testPhone: e.target.value })}
                className="flex-1 px-3 py-2 border rounded"
                placeholder="+33612345678"
              />
              <button
                type="button"
                onClick={handleTest}
                disabled={loading}
                className="px-4 py-2 bg-yellow-600 text-white rounded disabled:opacity-50"
              >
                Tester
              </button>
            </div>
          </div>

          <button
            type="button"
            onClick={handleSend}
            disabled={loading}
            className="w-full px-4 py-2 bg-green-600 text-white rounded disabled:opacity-50"
          >
            {loading ? 'Envoi...' : 'Envoyer à tous'}
          </button>
        </div>
      )}
    </form>
  );
};
```

## 💬 Composant WhatsApp

```typescript
// components/WhatsAppForm.tsx
import React, { useState } from 'react';
import { useMailingService } from '../hooks/useMailingService';

interface WhatsAppFormProps {
  eventId: number;
  token: string;
  onSuccess?: () => void;
}

export const WhatsAppForm: React.FC<WhatsAppFormProps> = ({ eventId, token, onSuccess }) => {
  const { createMailing, sendMailing, loading, error } = useMailingService(token);
  const [formData, setFormData] = useState({
    body: '',
    recipients: '',
  });

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    try {
      const mailing = await createMailing({
        event_id: eventId,
        body: formData.body,
        channel: 'whatsapp',
        recipients: formData.recipients.split('\n').filter(r => r.trim()),
      });

      await sendMailing(mailing.id);
      alert('Message WhatsApp envoyé!');
      onSuccess?.();
    } catch (err) {
      console.error(err);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div>
        <label className="block text-sm font-medium">Message WhatsApp</label>
        <textarea
          value={formData.body}
          onChange={(e) => setFormData({ ...formData, body: e.target.value })}
          className="w-full px-3 py-2 border rounded"
          rows={4}
          required
        />
      </div>

      <div>
        <label className="block text-sm font-medium">Numéros WhatsApp</label>
        <textarea
          value={formData.recipients}
          onChange={(e) => setFormData({ ...formData, recipients: e.target.value })}
          className="w-full px-3 py-2 border rounded"
          rows={3}
          placeholder="+33612345678&#10;+33687654321"
          required
        />
      </div>

      {error && <div className="text-red-600">{error}</div>}

      <button
        type="submit"
        disabled={loading}
        className="w-full px-4 py-2 bg-green-600 text-white rounded disabled:opacity-50"
      >
        {loading ? 'Envoi...' : 'Envoyer'}
      </button>
    </form>
  );
};
```

## 📊 Composant Statistiques

```typescript
// components/MailingStatistics.tsx
import React, { useEffect, useState } from 'react';
import { useMailingService } from '../hooks/useMailingService';

interface MailingStatisticsProps {
  eventId: number;
  token: string;
}

export const MailingStatistics: React.FC<MailingStatisticsProps> = ({ eventId, token }) => {
  const { getStatistics, loading } = useMailingService(token);
  const [stats, setStats] = useState<any>(null);

  useEffect(() => {
    const fetchStats = async () => {
      try {
        const data = await getStatistics(eventId);
        setStats(data);
      } catch (err) {
        console.error(err);
      }
    };

    fetchStats();
    const interval = setInterval(fetchStats, 30000); // Rafraîchir toutes les 30s

    return () => clearInterval(interval);
  }, [eventId]);

  if (loading || !stats) return <div>Chargement...</div>;

  return (
    <div className="grid grid-cols-2 gap-4">
      <div className="bg-blue-50 p-4 rounded">
        <p className="text-sm text-gray-600">Total</p>
        <p className="text-2xl font-bold">{stats.total_mailings}</p>
      </div>

      <div className="bg-green-50 p-4 rounded">
        <p className="text-sm text-gray-600">Envoyés</p>
        <p className="text-2xl font-bold">{stats.sent}</p>
      </div>

      <div className="bg-red-50 p-4 rounded">
        <p className="text-sm text-gray-600">Échoués</p>
        <p className="text-2xl font-bold">{stats.failed}</p>
      </div>

      <div className="bg-yellow-50 p-4 rounded">
        <p className="text-sm text-gray-600">Brouillons</p>
        <p className="text-2xl font-bold">{stats.draft}</p>
      </div>

      <div className="col-span-2 bg-gray-50 p-4 rounded">
        <p className="text-sm font-medium mb-2">Par canal</p>
        <div className="grid grid-cols-4 gap-2 text-sm">
          <div>Email: {stats.by_channel.email}</div>
          <div>SMS: {stats.by_channel.sms}</div>
          <div>WhatsApp: {stats.by_channel.whatsapp}</div>
          <div>MMS: {stats.by_channel.mms}</div>
        </div>
      </div>
    </div>
  );
};
```

## 🎯 Composant Principal

```typescript
// components/MailingCenter.tsx
import React, { useState } from 'react';
import { EmailForm } from './EmailForm';
import { SMSForm } from './SMSForm';
import { WhatsAppForm } from './WhatsAppForm';
import { MailingStatistics } from './MailingStatistics';

interface MailingCenterProps {
  eventId: number;
  token: string;
}

export const MailingCenter: React.FC<MailingCenterProps> = ({ eventId, token }) => {
  const [activeTab, setActiveTab] = useState<'email' | 'sms' | 'whatsapp' | 'stats'>('email');

  return (
    <div className="max-w-4xl mx-auto p-6">
      <h1 className="text-3xl font-bold mb-6">Centre de Mailing</h1>

      <div className="flex gap-2 mb-6 border-b">
        {['email', 'sms', 'whatsapp', 'stats'].map((tab) => (
          <button
            key={tab}
            onClick={() => setActiveTab(tab as any)}
            className={`px-4 py-2 font-medium ${
              activeTab === tab
                ? 'border-b-2 border-blue-600 text-blue-600'
                : 'text-gray-600'
            }`}
          >
            {tab.toUpperCase()}
          </button>
        ))}
      </div>

      <div className="bg-white p-6 rounded-lg shadow">
        {activeTab === 'email' && <EmailForm eventId={eventId} token={token} />}
        {activeTab === 'sms' && <SMSForm eventId={eventId} token={token} />}
        {activeTab === 'whatsapp' && <WhatsAppForm eventId={eventId} token={token} />}
        {activeTab === 'stats' && <MailingStatistics eventId={eventId} token={token} />}
      </div>
    </div>
  );
};
```

## 📝 Utilisation

```typescript
// Dans votre page principale
import { MailingCenter } from './components/MailingCenter';

export default function EventPage() {
  const eventId = 1;
  const token = localStorage.getItem('auth_token');

  return (
    <div>
      <MailingCenter eventId={eventId} token={token!} />
    </div>
  );
}
```

---

Ces composants fournissent une interface complète pour gérer tous les canaux de communication!
