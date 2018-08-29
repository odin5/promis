data = {
  lastUpdate: Date.now().toString(),
  planSlots: [
    {
      id: 1,
      workId: 1,
      turnId: 1,
      teams: {
        teamId: 1,
        count: 1,
      }
    },
    {
      id: 1,
      workId: 1,
      turnId: 1,
    },
  ],
  turns: [ // ngrid columns
    {
      id: 1,
      name: '1',
      weatherId: 1,
    },
  ],
  works: [ // grid rows
    {
      id: 1,
      name: 'Kopání základů',
      percentPlanned: 0,
      percentDone: null,
      costs: 0,
    },
  ],
  weathers: [
    {
      id: 1,
      color: '#ffff00',
      label: 'bude pršet',
    },
  ],
  teams: [
    {
      id: 1,
      name: 'vlastní',

    },
  ],
};