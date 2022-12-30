const toggleWelcomeModal = ({commit}) => {
    // state.welcomeModal = !state.welcomeModal;
    commit('UPDATE_WELCOME_MODAL');
};

const toggleSidebarFilter = ({state}) => {
    state.sidebarFilter = ! state.sidebarFilter;

    $('.sidebar-filter').toggleClass('show');
};

const updateFilterValues = ({commit}, payload) => {
    commit('UPDATE_FILTER_VALUES', payload);
};

const selectAllRows = ({commit}, payload) => {
    commit('SELECT_ALL_ROWS', payload);
};

const selectTableRow = ({commit}, payload) => {
    commit('SELECT_TABLE_ROW', payload);
};

const updateTableData = ({state}, payload) => {
    state.tableData = payload;
};

const pushToTableData = ({state}, payload) => {
    state.tableData.records.data.push(payload);
    state.tableData.records.total = 1
};

const updateTableRow = ({commit}, payload) => {
    commit('UPDATE_TABLE_ROW', payload);
};

export default {
    toggleWelcomeModal,
    toggleSidebarFilter,
    updateFilterValues,
    selectAllRows,
    selectTableRow,
    updateTableData,
    pushToTableData,
    updateTableRow
};
