import React from 'react';
import ReactDOM from "react-dom";
import { HydraAdmin, hydraClient, fetchHydra, AdminBuilder } from '@api-platform/admin';
import parseHydraDocumentation from '@api-platform/api-doc-parser/lib/hydra/parseHydraDocumentation';

const apiPrefix = '/api';

const customFetch = (url, options = {}) => {
  // fix https://github.com/api-platform/api-platform/issues/584
  url = url.replace(`${apiPrefix}${apiPrefix}/`, `${apiPrefix}/`);
  return fetchHydra(url, options);
};

const apiPlatformAdminScreen = document.getElementById('api-platform-admin-screen');
if(apiPlatformAdminScreen) {
  let entrypoint = window.location.protocol + '//' + window.location.hostname;
  if([80,443].indexOf(window.location.port) < 0) entrypoint += ":"+ window.location.port;
  entrypoint += '/api';


  ReactDOM.render(
    <HydraAdmin
      entrypoint={entrypoint}
      dataProvider={api => hydraClient(api, customFetch)}
    />,
    apiPlatformAdminScreen
  );



//   class Hej extends React.Component {
//     state = { api: null };
//
//     componentDidMount() {
//       parseHydraDocumentation(entrypoint).then(({api}) => {
//           // const books = api.resources.find(({ name }) => 'books' === name)
//           // const authors = books.fields.find(({ name }) => 'authors' === name)
//           //
//           // // Set the field in the list and the show views
//           // authors.field = props => (
//           //   <ReferenceArrayField source={authors.name} reference={authors.reference.name} key={authors.name} {...props}>
//           //     <SingleFieldList>
//           //       <ChipField source="name" key="name"/>
//           //     </SingleFieldList>
//           //   </ReferenceArrayField>
//           // );
//           //
//           // // Set the input in the edit and create views
//           // authors.input = props => (
//           //   <ReferenceArrayInput source={authors.name} reference={authors.reference.name} label="Authors" key={authors.name} {...props} allowEmpty>
//           //     <SelectArrayInput optionText="name"/>
//           //   </ReferenceArrayInput>
//           // );
// console.log(api);
//           this.setState({ api });
//         }
//       )
//     }
//
//     render() {
//       if (null === this.state.api) return <div>Loading...</div>;
//
//       return <AdminBuilder api={ this.state.api } dataProvider={api => hydraClient(api, customFetch)}/>
//     }
//   }
//
//   ReactDOM.render(
//     <Hej
//
//     />,
//     apiPlatformAdminScreen
//   );
} 