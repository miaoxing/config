import {Table, TableActions, TableProvider, CTableDeleteLink} from '@mxjs/a-table';
import {CEditLink, CNewBtn} from '@mxjs/a-clink';
import {Page, PageActions} from '@mxjs/a-page';

const Index = () => {
  return (
    <Page>
      <TableProvider>
        <PageActions>
          <CNewBtn/>
        </PageActions>

        <Table
          columns={[
            {
              title: '名称',
              dataIndex: 'name',
            },
            {
              title: '类型',
              dataIndex: 'typeName',
            },
            {
              title: '值',
              dataIndex: 'value',
            },
            {
              title: '更新时间',
              dataIndex: 'updatedAt',
            },
            {
              title: '操作',
              dataIndex: 'id',
              render: (id) => (
                <TableActions>
                  <CEditLink id={id}/>
                  <CTableDeleteLink id={id}/>
                </TableActions>
              ),
            },
          ]}
        />
      </TableProvider>
    </Page>
  );
};

export default Index;
